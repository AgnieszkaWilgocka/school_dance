
document.addEventListener("scroll", function() {
    const windowH = window.innerHeight;
    const scrollValue = window.scrollY;

    const p_first = document.querySelector(".p_first");
    const p_second = document.querySelector(".p_second");
    // const animOne = document.querySelector(".anim_one");
    const animOne = document.querySelector(".about_prob");

    const animTwo = document.querySelector(".offset");
    // const animTwo = document.querySelector(".te");

    const animOneFromTop = animOne.offsetTop;
    const animOneHeight = animOne.offsetHeight;
    const animTwoFromTop = animTwo.offsetTop;
    // const animTwoFromTop = p_first.offsetTop;

    const animTwoHeight = animTwo.offsetHeight;
    // const animTwoHeight = p_first.offsetHeight;


    if (scrollValue > animOneFromTop + animOneHeight - windowH) {
        p_first.classList.add("active");
    }

    if (scrollValue < 100) {
        p_first.classList.remove("active");
    }

    if (scrollValue > animTwoFromTop + animTwoHeight - windowH) {
        p_second.classList.add("active");
    }

    if (scrollValue < 100) {
        p_second.classList.remove("active");
    }
})
