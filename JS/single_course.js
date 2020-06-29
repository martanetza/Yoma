document.querySelector(".module-list-element-content").classList.add("show");
document.querySelector(".item-list-element").classList.add("white");
function openContent(moduleId, locked) {
  console.log(event.target);
  if (locked == 0) {
    document
      .querySelector("#content-module-" + moduleId)
      .classList.toggle("show");
  }
  console.log(document.querySelector("#content-module-" + moduleId + " div"));
}

function fetchSingleItemContent(itemId) {
  document.querySelectorAll(".item-list-element").forEach((e) => {
    e.classList.remove("white");
  });
  document.querySelector(".element-" + itemId).classList.add("white");
  async function fetchingData() {
    var jResponse = await fetch(`PHP/get_single_item.php?item_id=${itemId}`);
    var jData = await jResponse.json();
    console.log(jData);
    document.querySelector(".modal").innerHTML = `
      <div class="go-back">
          <i class="fas fa-angle-left fa-2x"></i>
      </div>
      <button onclick="openComments(${jData[0].item_id})" class="btn comments-btn"><i class="far fa-comments"></i> comments</button>
      <h1>${jData[0].item_title}</h1>
      <p>${jData[0].item_content}</p>`;
    document.querySelector(".modal").classList.toggle("show-modal");
    document.querySelector(".go-back").addEventListener("click", () => {
      document.querySelector(".modal").classList.toggle("show-modal");
    });
  }
  fetchingData();
}

function fetchTest(module_id, course_id, next_module_id) {
  var test_template_copy = test_template;
  console.log(module_id);
  async function fetchingDataTest(module_id) {
    document.querySelector(".modal").classList.toggle("show-modal");

    var jResponse = await fetch(
      `PHP/get_single_test_item.php?module_id=${module_id}`
    );
    var jData = await jResponse.json();
    var test_item_id = jData[0].test_item_id;
    console.log("test_item_id", jData[0].test_item_id);
    test_template_copy = test_template_copy.replace(
      "::Question::",
      jData[0].question
    );
    test_template_copy = test_template_copy.replace(
      "::answer_A::",
      jData[0].option_a
    );
    test_template_copy = test_template_copy.replace(
      "::answer_B::",
      jData[0].option_b
    );
    test_template_copy = test_template_copy.replace(
      "::answer_C::",
      jData[0].option_c
    );
    test_template_copy = test_template_copy.replace(
      "::answer_D::",
      jData[0].option_d
    );

    document.querySelector(".modal").innerHTML = test_template_copy;

    controlCheckboxes();
    document.querySelector(".submit-btn").addEventListener("click", () => {
      validateTheAnswer(jData, course_id, next_module_id, test_item_id);
    });
  }
  fetchingDataTest(module_id);
}

function controlCheckboxes() {
  var allOptions = document.querySelectorAll(
    "#answer_A, #answer_B, #answer_C, #answer_D"
  );
  allOptions.forEach((e) => {
    console.log(e);
    e.addEventListener("input", () => {
      allOptions.forEach((elm) => {
        if (e.id !== elm.id) {
          elm.checked = false;
        }
      });
    });
  });
}

function validateTheAnswer(data, courseID, next_module_id, test_item_id) {
  var allOptions = document.querySelectorAll(
    "#answer_A, #answer_B, #answer_C, #answer_D"
  );
  allOptions.forEach((elm) => {
    console.log(elm.value, data[0].answer, elm.checked);
    if (elm.value == data[0].answer && elm.checked) {
      if (next_module_id) {
        document.querySelector(".modal .test-container").innerHTML = `
          <div class="test-icon">
          <i class="fas fa-lock-open fa-5x"></i>
          </div>
          <div class="message"> 
          <p>Congratualtions your answer was correct you can move now to the next module <p> 
          </div>`;
        document
          .querySelector("#header-module-" + next_module_id)
          .setAttribute("onclick", `openContent(${next_module_id},0)`);
        document.querySelector(
          "#header-module-" + next_module_id + " .lock"
        ).innerHTML = '<i class="fas fa-lock-open"></i>';
        console.log(document.querySelector("#header-module-" + next_module_id));
      } else {
        document.querySelector(".modal .test-container").innerHTML = `
          <div class="test-icon">
          <i class="fas fa-grin-stars fa-5x"></i>
          </div>
          <div class="message">
          <p>Congratualtions! You have finished the course successfully!</p>
          </div>`;
      }
      save_progress(courseID, test_item_id);
    } else if (elm.value !== data[0].answer && elm.checked) {
      document.querySelector(".modal .test-container").innerHTML = `
        <div class="test-icon error-icon">
        <i class="fas fa-times fa-5x"></i>
        </div>
        <div class="message"> 
        <p>Ups! That is not a correct ansver. Try to study a bit more and retake the test<p> 
        </div>`;
    }
  });
}

function save_progress(courseID, test_item_id) {
  (async function () {
    var jResponse = await fetch(
      `PHP/save_progress.php?course_id=${courseID}&test_item_id=${test_item_id}`
    );
    var text = await jResponse.text();
    if (text.includes("Duplicated test entry")) {
      console.log("Duplicated test entry");
      document.querySelector(".modal .test-container").innerHTML = `
        <div class="test-icon">
        <i class="fas fa-lock-open fa-5x"></i>
        </div>
        <div class="message"> 
        <p> Correct! You have already passed this test successfully before <p> 
        </div>`;
    }
  })();
}
