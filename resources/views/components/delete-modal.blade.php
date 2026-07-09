<div id="deleteModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-slate-900/60 backdrop-blur-sm transition-all duration-300">

    <div id="deleteModalCard"
        class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2.5 bg-rose-50 rounded-xl text-rose-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 01..." />
                </svg>
            </div>

            <div>
                <h5 id="deleteModalTitle" class="text-lg font-bold text-slate-900">
                    Xác nhận xóa
                </h5>
                <p id="deleteModalDescription" class="text-xs text-slate-500 mt-0.5">
                    Bạn có chắc chắn muốn xóa dữ liệu này?
                </p>
            </div>
        </div>
        <div id="categoryOptions" class="hidden space-y-4 my-5">

            <p class="text-sm text-slate-600">
                Vui lòng chọn phương án xử lý sản phẩm con:
            </p>

            <div class="space-y-3">

                <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                    <input type="radio"
                        name="delete_option"
                        value="delete_all"
                        checked
                        class="mt-1 w-4 h-4 text-indigo-600">

                    <span class="text-sm font-semibold text-slate-800">
                        Xóa tất cả sản phẩm
                    </span>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                    <input type="radio"
                        name="delete_option"
                        value="move"
                        class="mt-1 w-4 h-4 text-indigo-600">

                    <span class="text-sm font-semibold text-slate-800">
                        Chuyển sang danh mục khác
                    </span>
                </label>

            </div>

            <select id="new_category_id"
                class="w-full px-3.5 py-2 text-sm border rounded-xl disabled:bg-slate-50"
                disabled>
            </select>
        </div>
        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
            <button type="button"
                id="closeDeleteModal"
                class="px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-xl">
                Hủy
            </button>

            <button type="button"
                id="confirmDeleteBtn"
                class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl">
                Xác nhận
            </button>

        </div>

    </div>
</div>

