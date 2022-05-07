function openBurgerMenu() {
  // 1.find the burger element in the DOM and save in variable
  const burger = document.querySelector('.mobile-menu');
  const header = document.querySelector('#header');
  

  // 2. add event listener for when you click on the burger it adds a class to the header
  burger.addEventListener('click', function(){
      header.classList.add("mobile-menu-open");
      
  })

  // 1.add event eventlistener for when I click the close button, the class in the header is removed
  const closeButton = document.querySelector('.close-menu');

  // 2. add event listener for when you click on the burger it removes a class to the header
  closeButton.addEventListener('click', function(){
    header.classList.remove("mobile-menu-open");
  })



}

openBurgerMenu();