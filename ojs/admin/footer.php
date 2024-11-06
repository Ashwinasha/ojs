<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 - Vanilla JS equivalent is not straightforward, so using a custom dropdown if necessary
    // Placeholder: Custom dropdown functionality implementation would go here.

    window.start_load = function() {
      let preloader = document.createElement('div');
      preloader.id = 'preloader2';
      document.body.prepend(preloader);
    }

    window.end_load = function() {
      const preloader = document.getElementById('preloader2');
      if (preloader) {
        preloader.style.display = 'none';
        preloader.remove();
      }
    }

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

   

    window.alert_toast = function($msg = 'TEST', $bg = 'success', $pos = '') {
      const toast = Swal.mixin({
        toast: true,
        position: $pos || 'top-end',
        showConfirmButton: false,
        timer: 5000
      });

      toast.fire({
        icon: $bg,
        title: $msg
      });
    }

    // Initialize summernote editor
    document.querySelectorAll('.summernote').forEach(function(el) {
      // Summernote equivalent in Vanilla JS would need a custom implementation.
      // This is typically done via other rich-text editors in vanilla JS.
    });

    // Number input handler to format numbers
    document.querySelectorAll('.number').forEach(function(el) {
      el.addEventListener('input', handleNumberInput);
      el.addEventListener('keyup', handleNumberInput);
      el.addEventListener('keypress', handleNumberInput);
    });

    function handleNumberInput(event) {
      let val = event.target.value;
      val = val.replace(/[^0-9]/g, '');
      val = val.replace(/,/g, '');
      val = val > 0 ? parseFloat(val).toLocaleString('en-US') : 0;
      event.target.value = val;
    }
  });
</script>
