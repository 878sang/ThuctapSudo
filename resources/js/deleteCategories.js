let deleteState = {
    id: null,
    url: null,
    type: null
};

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;

    openDeleteModal(
        btn.dataset.id,
        btn.dataset.url,
        btn.dataset.type
    );
});


window.openDeleteModal = openDeleteModal;
async function openDeleteModal(id, url, type) {
    if (!url) {
        url = `/categories/${id}`;
    }
    if (!type) {
        type = 'category';
    }

    deleteState = { id, url, type };

    const modal = document.getElementById('deleteModal');
    const card = document.getElementById('deleteModalCard');
    const options = document.getElementById('categoryOptions');


    document.getElementById('deleteModalTitle').innerText =
        type === 'category' ? 'Xóa danh mục' : 'Xác nhận xóa';

    document.getElementById('deleteModalDescription').innerText =
        type === 'category'
            ? 'Danh mục có thể chứa sản phẩm.'
            : 'Bạn có chắc chắn muốn xóa?';

    resetModalUI();

    if (type === 'category') {
        options.classList.remove('hidden');
        await loadCategoryData(id);
    } else {
        options.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    void modal.offsetWidth;

    card.classList.remove('scale-95', 'opacity-0');
    card.classList.add('scale-100', 'opacity-100');
}


function resetModalUI() {
    const select = document.getElementById('new_category_id');

    if (select) {
        select.innerHTML = '';
        select.disabled = true;
    }

    const radio = document.querySelector('input[value="delete_all"]');
    if (radio) radio.checked = true;
}


async function loadCategoryData(id) {
    try {
        const res = await fetch(`/categories/${id}/check`);
        const data = await res.json();

        const select = document.getElementById('new_category_id');
        select.innerHTML = '';

        (data.other_categories || []).forEach(c => {
            select.innerHTML += `<option value="${c.id}">${c.name}</option>`;
        });

        select.disabled = true;

    } catch (error) {
        console.error(error);
        alert('Lỗi tải dữ liệu category');
    }
}


document.addEventListener('click', function (e) {
    if (e.target.closest('#closeDeleteModal')) {
        closeDeleteModal();
    }
});

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const card = document.getElementById('deleteModalCard');

    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 150);
}


document.addEventListener('change', function (e) {
    if (e.target.name === 'delete_option') {
        const select = document.getElementById('new_category_id');
        if (!select) return;

        select.disabled = (e.target.value !== 'move');
    }
});

document.addEventListener('click', function (e) {
    const btn = e.target.closest('#confirmDeleteBtn');
    if (!btn) return;

    handleDelete();
});


async function handleDelete() {

    let payload = {};

    if (deleteState.type === 'category') {

        const option = document.querySelector(
            'input[name="delete_option"]:checked'
        )?.value;

        if (option === 'delete_all') {
            payload.option = 'delete_products_and_category';
        }

        if (option === 'move') {
            const newId = document.getElementById('new_category_id').value;

            if (!newId) {
                alert('Vui lòng chọn danh mục!');
                return;
            }

            payload.option = 'move_products_and_delete_category';
            payload.new_category_id = newId;
        }
    }

    await sendDeleteRequest(payload);
}

async function sendDeleteRequest(payload = {}) {

    if (deleteState.type !== 'category') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteState.url;
        form.style.display = 'none';


        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
        return;
    }

    try {
        const res = await fetch(deleteState.url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra!');
        }

    } catch (error) {
        console.error(error);
        alert('Lỗi hệ thống!');
    }
}