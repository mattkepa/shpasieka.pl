document.addEventListener('DOMContentLoaded', function() {
    (function() {
        const form = document.querySelector('#email-us > form');
        const inputs = Array.from(form.querySelectorAll('input, textarea'));
        
        function isEmpty(input) {
            return input.value == "";
        }

        function formValidate(e) {
            let isValid = true;
            // if(form.children[form.children.length - 1].classList.contains('alert')) form.removeChild(form.children[form.children.length - 1]);
            if(form.lastElementChild.classList.contains('alert')) form.removeChild(form.lastElementChild);

            inputs.forEach(function(input) {
                if(isEmpty(input)) {
                    if(input.classList.contains('is-valid')) {
                        input.classList.remove('is-valid');
                        input.dataset.errorMsg = 'To pole jest wymagane.';
                        let errorMsgElem = document.createElement('div');
                        errorMsgElem.classList.add('invalid-feedback');
                        errorMsgElem.innerHTML = input.dataset.errorMsg;
                        input.parentNode.appendChild(errorMsgElem);
                        input.classList.add('is-invalid');
                    } else {
                        if(!input.classList.contains('is-invalid')) {
                            input.dataset.errorMsg = 'To pole jest wymagane.';
                            let errorMsgElem = document.createElement('div');
                            errorMsgElem.classList.add('invalid-feedback');
                            errorMsgElem.innerHTML = input.dataset.errorMsg;
                            input.parentNode.appendChild(errorMsgElem);
                            input.classList.add('is-invalid');
                        }
                    }
                    isValid = false;
                } else {
                    if(!input.classList.contains('is-valid')) {
                        if(input.classList.contains('is-invalid')) {
                            input.dataset.errorMsg = "";
                            input.parentNode.removeChild(input.parentNode.lastChild);
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        } else {
                            input.classList.add('is-valid');
                        }
                    }
                }
            });
            
            if(!isValid) {
                e.preventDefault();
                let errMsgBlock = document.createElement('div');
                errMsgBlock.classList.add('alert', 'alert-danger', 'alert-custom-invalid');
                errMsgBlock.innerHTML = `<i class="fa fa-exclamation-triangle mr-2" aria-hidden="true"></i>Przynajmniej jedno pole zostało błędnie wypełnione.<br/>Sprawdź wpisaną treść i spróbuj ponownie.`;
                form.appendChild(errMsgBlock);
            }
        }

        inputs.forEach(input => input.removeAttribute('required'));
        
        form.addEventListener('submit', formValidate);
    })();
})