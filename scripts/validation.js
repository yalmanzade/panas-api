emailList = document.querySelectorAll('[type=email]');
submitList = document.querySelectorAll('[type=submit]');
resetList = document.querySelectorAll('[type=reset]');
let count = 0;
emailList.forEach((element) => {
  //   element.onChange = validateEmail(element);
  //   element.input = alert('Alert Changed');
  element.addEventListener('input', function () {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value)) {
      enableButtons();
      element.classList.remove('error');
      return true;
    }
    // alert('You have entered an invalid email address!');
    disableButtons();
    element.classList.add('error');
    return false;
  });
});
function disableButtons() {
  resetList.forEach((element) => {
    element.disabled = true;
  });
  submitList.forEach((element) => {
    element.disabled = true;
  });
}
function enableButtons() {
  resetList.forEach((element) => {
    element.disabled = false;
  });
  submitList.forEach((element) => {
    element.disabled = false;
  });
}
window.onload = disableButtons();
