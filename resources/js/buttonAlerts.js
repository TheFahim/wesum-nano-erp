import Swal from 'sweetalert2';

import { blogEditor, textAreaEditor } from './sunEditor';

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent any default action for the button
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                background: 'rgb(55 65 81)',
                customClass: {
                    title: 'text-white',
                    htmlContainer: '!text-white',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form explicitly using the `form` attribute of the button
                    const formId = button.getAttribute('form');
                    const form = document.getElementById(formId);
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    });

    document.querySelectorAll('.save-button').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent any default action for the button
            Swal.fire({
                title: 'Are you sure?',
                text: "You can take time to review your changes before saving!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                background: 'rgb(55 65 81)',
                customClass: {
                    title: 'text-white',
                    htmlContainer: '!text-white',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form explicitly using the `form` attribute of the button

                    if (textAreaEditor) {
                        // Get the SunEditor's content
                        const editorContent = textAreaEditor.getContents();

                        // Find the textarea in the form
                        const formTextArea = button.closest('form').querySelector('textarea');

                        // Set the content to the textarea's value
                        formTextArea.value = editorContent;
                    }

                    const form = button.closest('form');
                    if (form && form.checkValidity()) {
                        form.submit();
                    }else{
                        form.reportValidity();
                    }
                }
            });
        });
    });

    const disableButton = document.getElementById('disable');

    if (disableButton) {
        const dataUrl = disableButton.getAttribute('data-url');

        disableButton.addEventListener('click', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to disable the User!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                background: 'rgb(55 65 81)',
                customClass: {
                    title: 'text-white',
                    htmlContainer: '!text-white',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to a certain URL
                    window.location.href = dataUrl;
                }
            });
        });
    }

    const blogFormButton =  document.getElementById('blog-save');

    if (blogFormButton) {
        blogFormButton.addEventListener('click', function(event){
            event.preventDefault(); // Prevent any default action for the button
            Swal.fire({
                title: 'Are you sure?',
                text: "You can take time to review your changes before saving!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                background: 'rgb(55 65 81)',
                customClass: {
                    title: 'text-white',
                    htmlContainer: '!text-white',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form explicitly using the `form` attribute of the button
                    const form = blogFormButton.closest('form');

                    // Get the SunEditor's content
                    const editorContent = blogEditor.getContents();

                    // Find the textarea in the form
                    const formTextArea = form.querySelector('textarea');

                    // Set the content to the textarea's value
                    formTextArea.value = editorContent;

                    if (form && form.checkValidity()) {
                        form.submit();
                    }else{
                        form.reportValidity();
                    }
                }
            });
        });
    }

});
