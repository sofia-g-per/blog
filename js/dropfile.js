"use strict";
const previewImg = document.querySelector('.form__file-wrapper img');
const fileInp = document.querySelector('.form__input-file');
const deleteButton = document.querySelector('.form__delete-button');
const previewBox = document.querySelector('.dz-file-preview');
const fileNameBox = document.querySelector('.dz-filename');

deleteButton.addEventListener('click', function (evt){
  evt.preventDefault();
  fileInp.value="";
  localStorage.removeItem("image");
  localStorage.removeItem("filename");
  previewBox.style='dislpay:none';
});

window.onload = function() {
  const image = localStorage.getItem("image");
  const fileName = localStorage.getItem("filename");
  if (image !== null && (document.referrer == document.URL)) {
    fileNameBox.textContent = fileName;
    previewImg.src = image;
    previewBox.style='display:block';
  }
}

fileInp.addEventListener('change', function (){
  const file = fileInp.files[0];

  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = function () {
    localStorage.setItem("image", reader.result);
    localStorage.setItem("filename", file.name);
  };

  const image = URL.createObjectURL(file);
  fileNameBox.textContent = file.name;
  previewImg.src = image;
  previewBox.style='display:block';
});
