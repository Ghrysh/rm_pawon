document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const menuList = document.getElementById('menuList');
    const filterBtn = document.getElementById('filterBtn');
    const filterModal = document.getElementById('filterModal');
    const filterText = document.getElementById('filterText');
    const categoryItems = document.querySelectorAll('.category-item');
    
    let currentCategoryId = '';
    let searchTimeout;

    if (searchInput && menuList) {
        async function fetchMenus() {
            const query = searchInput.value;
            // Get URL from data attribute
            const searchUrl = searchInput.getAttribute('data-url');
            const url = `${searchUrl}?query=${encodeURIComponent(query)}&category_id=${currentCategoryId}`;
            
            try {
                const response = await fetch(url);
                const html = await response.text();
                menuList.innerHTML = html;
            } catch (error) {
                console.error("Error fetching menus:", error);
            }
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(fetchMenus, 300);
        });

        categoryItems.forEach(item => {
            item.addEventListener('click', () => {
                categoryItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                currentCategoryId = item.getAttribute('data-id');
                
                filterModal.classList.remove('active');
                if (filterText) filterText.innerText = 'Menu';

                fetchMenus();
            });
        });
    }

    if (filterBtn && filterModal && filterText) {
        filterBtn.addEventListener('click', () => {
            const isActive = filterModal.classList.contains('active');
            if (isActive) {
                filterModal.classList.remove('active');
                filterText.innerText = 'Menu';
            } else {
                filterModal.classList.add('active');
                filterText.innerText = 'Tutup';
            }
        });
    }
});
