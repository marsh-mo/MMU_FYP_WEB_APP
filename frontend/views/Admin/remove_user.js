let selectedUser = null;

function deleteUserInfo(userId) {
    selectedUser = userId;

    if (!confirm(`Are you sure you want to remove this user with ID ${userId}?`)) {
        return;
    }

    fetch('remove_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `user_id=${selectedUser}`
    })
    .then(response => response.json())
    .then(data => {
       
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
