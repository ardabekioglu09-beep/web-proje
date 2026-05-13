// Bursa sayfasındaki slayt görselleri ve hedef bölümler
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

let index = 0; // Aktif slayt indeksi

// Slayt görselini ve bağlantısını aynı anda günceller
function showSlide(i) {
    document.getElementById("sliderImage").src = images[i]; // Görseli günceller
    document.getElementById("link").href = targets[i]; // Hedef bölümü günceller
}

function nextSlide() {
    index = (index + 1) % images.length; // Bir sonraki slayta geç
    showSlide(index);
}

// Bir önceki slayda geri döner
function prevSlide() {
    index = (index - 1 + images.length) % images.length; // Bir önceki slayda dön
    showSlide(index);
}

// İlgi alanları sayfasındaki kartların veri kaynağı
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

// Steam indirim kartlarını sadece ilgili alan varsa oluşturur
if (gameContainer) {
    games.forEach(game => {
        let discountText = game.discount > 0
            ? `<p class="discount">%${game.discount} İndirim</p><p><del>${game.oldPrice}</del></p><p>${game.newPrice}</p>`
            : `<p class="no-discount">Şu anda indirim yok</p>`;

        gameContainer.innerHTML += `
        <div class="game-card">
            <img src="${game.image}" alt="${game.name}">
            <h2>${game.name}</h2>
            ${discountText}
        </div>`;
    });
}
// Teknoloji haber akışı için News API anahtarı ve hedef konteyner
const apiKey = "24f045ee0ae8453dbb8d60e188f2b47f";
const newsContainer = document.getElementById("news-container"); // Haber kartlarının basılacağı alan

// Haber alanı bulunan sayfalarda son teknoloji haberleri çekilir
if (newsContainer) {
    fetch(`https://newsapi.org/v2/everything?q=technology OR gaming OR NVIDIA OR Tesla&language=tr&sortBy=publishedAt&pageSize=5&apiKey=${apiKey}`)
        .then(response => response.json())
        .then(data => {
            if (!data.articles) return; // API boş dönerse çık

            data.articles.forEach(article => {
                const card = document.createElement('div');
                card.className = 'news-card';

                const title = document.createElement('h2');
                title.textContent = article.title;

                const desc = document.createElement('p');
                desc.textContent = article.description || 'Açıklama bulunamadı.';

                const link = document.createElement('a');
                link.href = article.url;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.textContent = 'Haberi Oku';

                card.appendChild(title);
                card.appendChild(desc);
                card.appendChild(link);
                newsContainer.appendChild(card);
            });
        })
        .catch(error => {
            console.error('News API hatası:', error);
        });
}