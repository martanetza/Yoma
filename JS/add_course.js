function chanegTitle() {
  event.target.parentElement.parentElement.querySelector(
    ".module-header div"
  ).textContent = event.target.value;
  console.log(event.target.parentElement.parentElement);
}

function addModule() {
  event.preventDefault();

  document
    .querySelector("form")
    .insertAdjacentHTML("beforeend", moduleTemplate);
}

function openModule() {
  event.target.parentElement
    .querySelector(".module-main")
    .classList.toggle("show-block");
}

var number_of_module_lessons = 1;

function addLesson() {
  event.preventDefault();
  number_of_module_lessons++;
  event.target.parentElement.querySelector(
    ".number_of_items"
  ).value = number_of_module_lessons;
  event.target.parentElement
    .querySelector(".module-items-template")
    .insertAdjacentHTML("beforeend", lessonTemplate);
}
