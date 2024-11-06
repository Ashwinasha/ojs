

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize select2 (Replace with native select elements or a non-jQuery select2 library)
    document.querySelectorAll('.select2').forEach(function (el) {
        // Assuming you have an alternative to select2 for vanilla JS
        el.style.width = "100%";
        el.setAttribute("placeholder", "Please select here");
    });

    window.start_load = function () {
        let preloader = document.createElement('div');
        preloader.id = "preloader2";
        document.body.prepend(preloader);
    };

    window.end_load = function () {
        let preloader = document.getElementById('preloader2');
        if (preloader) {
            preloader.style.display = 'none';
            preloader.remove();
        }
    };

    window.viewer_modal = function (src = '') {
        start_load();
        let view;
        if (src.split('.').pop() === 'mp4') {
            view = document.createElement('video');
            view.src = src;
            view.controls = true;
            view.autoplay = true;
        } else {
            view = document.createElement('img');
            view.src = src;
        }

        let modalContent = document.querySelector('#viewer_modal .modal-content');
        modalContent.innerHTML = '';  // Clear previous content
        modalContent.appendChild(view);

        let modal = document.getElementById('viewer_modal');
        modal.style.display = 'block';  // Show modal
        modal.setAttribute('aria-hidden', 'false');
        
        end_load();
    };

    window.uni_modal = function (title = '', url = '', size = '') {
        start_load();
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.querySelector('#uni_modal .modal-title').innerHTML = title;
                document.querySelector('#uni_modal .modal-body').innerHTML = html;

                let modalDialog = document.querySelector('#uni_modal .modal-dialog');
                modalDialog.className = size ? `modal-dialog ${size}` : 'modal-dialog modal-md';

                let modal = document.getElementById('uni_modal');
                modal.style.display = 'block';  // Show modal
                modal.setAttribute('aria-hidden', 'false');
                
                end_load();
            })
            .catch(error => {
                console.error(error);
                alert("An error occurred");
            });
    };

    window._conf = function (msg = '', func = '', params = []) {
        document.querySelector('#confirm_modal #confirm').onclick = function () {
            window[func](...params);
        };
        document.querySelector('#confirm_modal .modal-body').innerHTML = msg;
        let modal = document.getElementById('confirm_modal');
        modal.style.display = 'block';  // Show modal
        modal.setAttribute('aria-hidden', 'false');
    };

    window.alert_toast = function (msg = 'TEST', bg = 'success', pos = '') {
        let toast = document.createElement('div');
        toast.className = `toast ${bg}`;
        toast.innerHTML = `<div class="toast-body">${msg}</div>`;
        toast.style.position = 'absolute';
        toast.style.top = '10px';
        toast.style.right = '10px';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 5000);
    };

    window.load_cart = function () {
        fetch('admin/ajax.php?action=get_cart_count')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.cart-count').textContent = data.count;
                let cartProduct = document.getElementById('cart_product');
                if (Object.keys(data.list).length > 0) {
                    let ul = document.createElement('ul');
                    ul.className = 'list-group';
                    for (let k in data.list) {
                        let li = document.createElement('li');
                        li.className = 'list-group-item';
                        let div = document.createElement('div');
                        div.className = 'item d-flex justify-content-between align-items-center';
                        div.innerHTML = `
                            <div class="cart-img"><img src="${data.list[k].img_path}" alt=""></div>
                            <div class="cart-title"><b>${data.list[k].pname}</b></div>
                            <span><span class="badge badge-primary cart-qty"><b>${data.list[k].qty}</b></span></span>
                        `;
                        li.appendChild(div);
                        ul.appendChild(li);
                    }
                    cartProduct.innerHTML = '';
                    cartProduct.appendChild(ul);
                } else {
                    cartProduct.innerHTML = '<div class="d-block text-center bg-light"><b>No items.</b></div>';
                }
            });
    };

    // Load cart and initialize Summernote (Summernote replacement needed for Vanilla JS)
    load_cart();

    // Summernote replacement (using contenteditable div or another WYSIWYG editor)
    document.querySelectorAll('.summernote').forEach(function (el) {
        el.style.height = '300px';  // Set height for editor
    });

    // Format input as number
    document.querySelectorAll('.number').forEach(function (el) {
        el.addEventListener('input', function () {
            let val = el.value.replace(/[^0-9]/g, '').replace(/,/g, '');
            el.value = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        });
    });
});
</script>

