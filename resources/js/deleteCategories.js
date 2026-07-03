let deleteCategoryId = null;

document.querySelectorAll('input[name="delete_option"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const select = document.getElementById('new_category_id');
        select.disabled = (this.value !== 'move');
    });
});

window.closeDeleteModal = closeDeleteModal;
function closeDeleteModal() {
    const modal = document.getElementById('deleteCategoryModal');
    const card = document.getElementById('deleteCategoryModalCard');

    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 150);
}

window.openDeleteModal = openDeleteModal;
async function openDeleteModal(id) {
    deleteCategoryId = id;
    try {
        const res = await fetch(`/categories/${id}/check`);
        const data = await res.json();

        if (!data.has_products) {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                await deleteCategory(null, null);
            }
            return;
        }

        const select = document.getElementById('new_category_id');
        select.innerHTML = '';
        data.other_categories.forEach(c => {
            select.innerHTML += `<option value="${c.id}">${c.name}</option>`;
        });

        document.querySelector('input[value="delete_all"]').checked = true;
        select.disabled = true;

        const modal = document.getElementById('deleteCategoryModal');
        const card = document.getElementById('deleteCategoryModalCard');

        modal.classList.remove('hidden');

        void modal.offsetWidth;

        card.classList.remove('scale-95', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
    } catch (error) {
        console.error(error);
        alert("Lỗi tải dữ liệu kiểm tra");
    }
}

document.getElementById('confirmDeleteBtn').addEventListener('click', async function () {
    const selectedOption = document.querySelector('input[name="delete_option"]:checked').value;

    let optionParam = null;
    let newCategoryId = null;

    if (selectedOption === 'delete_all') {
        optionParam = 'delete_products_and_category';
    } else if (selectedOption === 'move') {
        optionParam = 'move_products_and_delete_category';
        newCategoryId = document.getElementById('new_category_id').value;
        if (!newCategoryId) {
            alert('Vui lòng chọn danh mục cần chuyển đến!');
            return;
        }
    }

    await deleteCategory(optionParam, newCategoryId);
});

async function deleteCategory(option, newCategoryId) {
    const res = await fetch(`/categories/${deleteCategoryId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            option: option,
            new_category_id: newCategoryId
        })
    });

    const data = await res.json();
    if (data.success) {
        location.reload();
    } else {
        alert('Có lỗi xảy ra khi xóa danh mục!');
    }
}