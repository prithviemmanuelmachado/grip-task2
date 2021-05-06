
function displayModal($cusID,$fname,$lname,$email,$balance)
{
    document.querySelector('.bg-modal').style.display='flex';
    document.getElementById('cID').value=$cusID;
    document.getElementById('fname').value=$fname;
    document.getElementById('lname').value=$lname;
    document.getElementById('email').value=$email;
    document.getElementById('balance').value=$balance;
}

function closeModal()
{
    document.querySelector('.bg-modal').style.display='none';
}
