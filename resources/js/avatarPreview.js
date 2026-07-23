document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'avatar') {
        const input = e.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('avatar-preview');
                if (preview) {
                    preview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = 'w-full h-full rounded-full object-cover border border-slate-100';
                    preview.appendChild(img);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
});
