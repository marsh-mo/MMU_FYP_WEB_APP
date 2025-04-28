function updateProposalStatus(proposalId, status) {
    if (!confirm(`Are you sure you want to ${status.toLowerCase()} this proposal?`)) {
        return;
    }

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `proposal_id=${proposalId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {     
            alert(data.message);
            location.reload(); // Refresh to reflect the new status
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
