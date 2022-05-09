// save all the tabs in avariable
const tabs = document.querySelectorAll(".tab");

// go over each one of the tabs
tabs.forEach((tab) => {

  // for each tab, listen for the event 'click'
  tab.addEventListener('click', function() {

    // make the tabs change class .active on click
    let activeTab = document.querySelector(".active");
    activeTab.classList.remove("active"); //remove the class ative from the tab is active now
    tab.classList.add("active"); // add the class active to the tab that I clicked

    // make the content-tabs change the class visible on click
    let dataTab = tab.getAttribute('data-tab'); //save the attribute data-tab of the tab I have just clicked
    let contentTab = document.getElementById(dataTab); //find the content-tab with id the same as the attribute data-tab that I just clicked
    let visibleContentTab = document.querySelector(".visible"); // find the contant-tab that is visible

    visibleContentTab.classList.remove("visible"); // remove the class visible from the content-tab that is visible now
    contentTab.classList.add("visible"); //add class visible to the contant-tab with the same id as the attribute data-tab that I clicked
  })
});