let images = [
    "İmages/BursaGörsel1.jpg",
    "İmages/BursaGörsel2.jpg",
    "İmages/BursaGörsel3.jpg",
    "İmages/BursaGörsel4.jpg"
];

let targets = [
    "#bursa",
    "#takim",
    "#kultur",
    "#lezzet"
];

let index = 0;

function showSlide(i) {
    document.getElementById("sliderImage").src = images[i];
    document.getElementById("link").href = targets[i];
}

function nextSlide() {
    index = (index + 1) % images.length;
    showSlide(index);
}

function prevSlide() {
    index = (index - 1 + images.length) % images.length;
    showSlide(index);
}