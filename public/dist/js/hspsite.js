function toggleMenu(element) {
    // Add menu-open class to clicked Li
    var activeMenu = element.querySelector('.myMenu');
    parentLi.classList.toggle("menu-open");

    // Add active class to clicked anchor
    var activeAnchor = element.querySelector('.nav-link');
    activeAnchor.classList.toggle("active");
}