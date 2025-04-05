// Modal functions
function openAddStudentModal() {
    document.getElementById('addStudentModal').style.display = 'block';
}

function closeAddStudentModal() {
    document.getElementById('addStudentModal').style.display = 'none';
}

function openUpdateStudentModal(id, name, roll_no, email) {
    document.getElementById('updateStudentModal').style.display = 'block';
    document.getElementById('update_id').value = id;
    document.getElementById('update_name').value = name;
    document.getElementById('update_roll_no').value = roll_no;
    document.getElementById('update_email').value = email;
}

function closeUpdateStudentModal() {
    document.getElementById('updateStudentModal').style.display = 'none';
}

// Delete functionality
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this student?')) {
            const id = this.getAttribute('data-id');
            fetch('delete_student.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        }
    });
});