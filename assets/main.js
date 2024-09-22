document.addEventListener('DOMContentLoaded', function() {


const player = document.querySelector(".movie-player");
    const iframe = player.querySelector("iframe");
    const video = player.querySelector("video");

    function handleLoad() {
        setTimeout(() => {
            player.classList.add("loaded");
        }, 700); // Thời gian chờ 0.7 giây để hiển thị
    }

    if (iframe) {
        iframe.onload = handleLoad;
    }

    if (video) {
        video.oncanplay = handleLoad;
    }

  // Lấy trạng thái active từ localStorage
  const activeEpisode = localStorage.getItem('activeEpisode');

  // Nếu có, thêm lớp active vào phần tử tương ứng
  if (activeEpisode) {
    document.querySelector(`.episode-list li > a[href="${activeEpisode}"]`)?.classList.add('active');
  }

  // Lắng nghe sự kiện click trên các liên kết tập phim
  document.querySelectorAll('.episode-list li > a').forEach(a => {
    a.addEventListener('click', function(e) {
      e.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết

      // Xóa lớp active khỏi phần tử hiện tại
      document.querySelector('.episode-list li > a.active')?.classList.remove('active');

      // Thêm lớp active vào phần tử được nhấp
      this.classList.add('active');

      // Lưu trạng thái active vào localStorage
      localStorage.setItem('activeEpisode', this.getAttribute('href'));
      window.location.href = this.href;
    });
  });
});


document.addEventListener('DOMContentLoaded', () => {


  const menuBtn = document.querySelector('.menu-btn');
  const headerNav = document.querySelector('#header-nav');
  const overlay = document.querySelector('.overlay');
  const closeMenu = document.querySelector('#close-menu');

  closeMenu.addEventListener('click', () => {
    headerNav.classList.remove('show');
    overlay.classList.remove('show');
  });

  // Toggle .show class on .header-nav and .overlay when .menu-btn is clicked
  menuBtn.addEventListener('click', () => {
    headerNav.classList.toggle('show');
    overlay.classList.toggle('show');
  });

  // Close the menu when clicking outside of .header-nav and .menu-btn
  document.addEventListener('click', (event) => {
    if (!headerNav.contains(event.target) && !menuBtn.contains(event.target)) {
      headerNav.classList.remove('show');
      overlay.classList.remove('show');
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const searchBtn = document.querySelector('.search-btn');
  const closeSearchBtn = document.querySelector('.close-search');
  const headerNav = document.querySelector('#header-search');

  // Hàm mở tìm kiếm
  const openSearch = () => {
    headerNav.classList.add('show');
    searchBtn.style.display = 'none';
    closeSearchBtn.style.display = 'block';
  };

  // Hàm đóng tìm kiếm
  const closeSearch = () => {
    headerNav.classList.remove('show');
    searchBtn.style.display = 'block';
    closeSearchBtn.style.display = 'none';
  };

  searchBtn.addEventListener('click', openSearch);
  closeSearchBtn.addEventListener('click', closeSearch);
});

// Lấy các phần tử cần thiết từ DOM
const sliders = document.querySelector('.sliders');
const prevBtn = document.querySelector('.slider-btn.prev');
const nextBtn = document.querySelector('.slider-btn.next');

// Biến để theo dõi bước trượt
let scrollStep = sliders.clientWidth / 2;

// Hàm kiểm tra và cập nhật trạng thái nút
function checkButtons() {
  const maxScrollLeft = sliders.scrollWidth - sliders.clientWidth;
  const currentScrollLeft = sliders.scrollLeft;

  // Vô hiệu hóa nút prev nếu đang ở đầu
  prevBtn.disabled = currentScrollLeft <= 0;
  prevBtn.classList.toggle('kill', currentScrollLeft <= 0);

  // Vô hiệu hóa nút next nếu đang ở cuối
  nextBtn.disabled = currentScrollLeft >= maxScrollLeft;
  nextBtn.classList.toggle('kill', currentScrollLeft >= maxScrollLeft);
}

// Sự kiện khi nhấn nút "Next"
nextBtn.addEventListener('click', () => {
  sliders.scrollBy({ left: scrollStep, behavior: 'smooth' });
});

// Sự kiện khi nhấn nút "Prev"
prevBtn.addEventListener('click', () => {
  sliders.scrollBy({ left: -scrollStep, behavior: 'smooth' });
});

// Sự kiện khi cuộn (trượt thủ công hoặc tự động) để đồng bộ hóa nút
sliders.addEventListener('scroll', checkButtons);

// Cập nhật lại scrollStep khi cửa sổ thay đổi kích thước
window.addEventListener('resize', () => {
  scrollStep = sliders.clientWidth / 2;
  checkButtons(); // Kiểm tra lại trạng thái nút sau khi thay đổi kích thước
});

// Kiểm tra trạng thái nút khi khởi tạo
checkButtons();

var iframe = document.querySelector(".movie-player iframe");
    var loadingOverlay = document.querySelector(".loading-overlay");

    iframe.onload = function() {
        iframe.classList.add("loaded");
        loadingOverlay.classList.add("hidden");
    };
    




