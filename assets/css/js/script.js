// Custom JavaScript for additional interactions

// Function to handle dynamic dropdown display for the teacher dashboard
document.addEventListener('DOMContentLoaded', function() {
    const gradeButtons = document.querySelectorAll('.grade-btn');

    gradeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const grade = this.getAttribute('data-grade');
            const subjectList = document.querySelector(`#grade-${grade}-subjects`);
            
            if (subjectList) {
                subjectList.classList.toggle('d-none');
            }
        });
    });

    // Function to handle topic form submission
    const topicForm = document.querySelector('#topic-form');
    if (topicForm) {
        topicForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch('add_topic.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log(result);
                // Handle the result, e.g., show a success message or redirect
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Function to handle file uploads
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileLabel = this.nextElementSibling;
            if (fileLabel) {
                fileLabel.textContent = this.files.length > 0 ? this.files[0].name : 'Choose file';
            }
        });
    });
});

// Custom function to confirm deletion of subjects, videos, PDFs, and assignments
function confirmDeletion(type, id) {
    return confirm(`Are you sure you want to delete this ${type}?`);
}

// Example usage: confirm deletion before sending delete request
document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function(event) {
        const type = this.getAttribute('data-type');
        const id = this.getAttribute('data-id');

        if (confirmDeletion(type, id)) {
            // Proceed with deletion
            fetch(`delete_${type}.php?id=${id}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(result => {
                console.log(result);
                // Handle the result, e.g., update the page or show a success message
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            event.preventDefault();
        }
    });
});
