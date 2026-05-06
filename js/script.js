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
const games = [
    {
        name: "Cyberpunk 2077",
        image: "https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/header.jpg",
        discount: 60,
        oldPrice: "999 TL",
        newPrice: "399 TL"
    },

    {
        name: "Resident Evil 4",
        image: "https://cdn.cloudflare.steamstatic.com/steam/apps/2050650/header.jpg",
        discount: 0,
        oldPrice: "",
        newPrice: ""
    },
    {
        name: "Amnesia: The Bunker",
        image: "https://cdn.cloudflare.steamstatic.com/steam/apps/1944430/header.jpg",
        discount: 40,
        oldPrice: "299 TL",
        newPrice: "179 TL"
    },
    {
        name: "Call of Duty 4: Modern Warfare",
        image: "https://cdn.cloudflare.steamstatic.com/steam/apps/7940/header.jpg",
        discount: 75,
        oldPrice: "199 TL",
        newPrice: "49 TL"
    }
];

const gameContainer = document.getElementById("game-data");

if (gameContainer) {
    games.forEach(game => {

        let discountText = "";

        if (game.discount > 0) {

            discountText = `
            <p class="discount">%${game.discount} İndirim</p>
            <p><del>${game.oldPrice}</del></p>
            <p>${game.newPrice}</p>
        `;

        } else {

            discountText = `
            <p class="no-discount">Şu anda indirim yok</p>
        `;
        }

        gameContainer.innerHTML += `
        <div class="game-card">

            <img src="${game.image}">

            <h2>${game.name}</h2>

            ${discountText}

        </div>
    `;
    });
}
const apiKey = "24f045ee0ae8453dbb8d60e188f2b47f";
const newsContainer = document.getElementById("news-container");

if (newsContainer) {
    fetch(`https://newsapi.org/v2/everything?q=technology OR gaming OR NVIDIA OR Tesla&language=tr&sortBy=publishedAt&pageSize=5&apiKey=${apiKey}`)

    .then(response => response.json())

    .then(data => {

        if (!data.articles) {
            return;
        }

        data.articles.forEach(article => {

            newsContainer.innerHTML += `
            <div class="news-card">
                <h2>${article.title}</h2>
                <p>${article.description || "Açıklama bulunamadı."}</p>
                <a href="${article.url}" target="_blank">
                    Haberi Oku
                </a>
            </div>
            `;
        });

    })
    .catch(error => {
        console.error("News API hatası:", error);
    });
}