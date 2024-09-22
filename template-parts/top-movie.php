<section id="top-movies">
    <h2 class="cat-title">Top Phim Xem Nhiều</h2>
    <div class="tab-container">
        <button class="tab-button active" data-filter="day">Hôm nay</button>
        <button class="tab-button" data-filter="week">Tuần này</button>
        <button class="tab-button" data-filter="month">Tháng này</button>
        <button class="tab-button" data-filter="year">Năm nay</button>
    </div>
    <ul id="movie-list" class="movie-list">
        <!-- Danh sách phim sẽ được tải ở đây -->
    </ul>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const movieList = document.getElementById('movie-list');

    function fetchTopMovies(filter) {
        fetch(`/wp-json/top-movies/v1/${filter}`)
            .then(response => response.json())
            .then(movies => {
                movieList.innerHTML = '';
                movies.forEach((movie, index) => {
                    const movieItem = `
                        <li class="tmovies-item">
                            <span class="rank">${index + 1}</span>
                            <img src="${movie.thumbnail}" alt="${movie.title}" class="tmovies-thumb" />
                            <div class="tmovies-info">
                                <a href="${movie.link}" class="tmovies-title">
                                    <h3>${movie.title}</h3>
                                </a>
                                <span class="movie-name-eng">${movie.eng_name}</span>
                            </div>
                        </li>
                    `;
                    movieList.insertAdjacentHTML('beforeend', movieItem);
                });
            });
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            fetchTopMovies(filter);
        });
    });

    // Load mặc định tab "Hôm nay"
    fetchTopMovies('day');
});
</script>
