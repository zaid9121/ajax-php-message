
$(document).ready(function() {
  const baseUrl = window.location.origin + '/';
  
  // Handle registration
  $('#registerForm').submit(function(e) {
  e.preventDefault();
  $.post('register_user.php', $(this).serialize(), function(response) {
  alert(response.message || 'Registration successful!');
  if (response.status === 'success') {
  window.location.href = 'login.php'; // Redirect to login page after registration
  }
  }, 'json');
  });
  
  // Handle login
  $('#loginForm').submit(function(e) {
  e.preventDefault();
  $.post('login_user.php', $(this).serialize(), function(response) {
  if (response.status === 'success') {
  window.location.href = 'messages.php'; // Redirect to messages page after login
  } else {
  alert(response.message || 'Login failed.');
  }
  }, 'json');
  });
  
  // Handle message submission
  $('#messageForm').submit(function(e) {
  e.preventDefault();
  $.post('submit_message.php', $(this).serialize(), function(response) {
  if (response.status === 'success') {
  loadMessages();
  $('#message').val(''); // Clear the message input
  } else {
  alert(response.message || 'Failed to submit message.');
  }
  }, 'json');
  });
  
  // Load messages
  function loadMessages() {
  $.getJSON('get_messages.php', function(data) {
  $('#messages').empty(); // Clear existing messages
  $.each(data, function(index, message) {
  $('#messages').append(`
  
<div class="container"><br><br> <br>
<h5>${message.username}</h5><br>                    
<p style="color: white;">${message.message}</p><br><br><br>                   
 <p style="color: #78e7de">${message.created_at}</p><br><br><br>                   
<button class="updateButton" data-id="${message.id}">Update</button><br>                    
<button class="deleteButton" data-id="${message.id}">Delete</button><br>                
</div>
  
  `);
  });
  
  // Attach events for update and delete buttons
  attachUpdateDeleteEvents();
  });
  }
  
  function attachUpdateDeleteEvents() {
  // Handle message update
  $('.updateButton').off('click').on('click', function() {
  const messageId = $(this).data('id');
  const newMessage = prompt("Edit your message:");
  if (newMessage) {
  $.post('update_message.php', { id: messageId, message: newMessage }, function(response) {
  alert(response.message || 'Message updated successfully!');
  if (response.status === 'success') {
  loadMessages(); // Reload messages after update
  }
  }, 'json');
  }
  });
  
  // Handle message deletion
  $('.deleteButton').off('click').on('click', function() {
  const messageId = $(this).data('id');
  if (confirm('Are you sure you want to delete this message?')) {
  $.post('delete_message.php', { id: messageId }, function(response) {
  alert(response.message || 'Message deleted successfully!');
  if (response.status === 'success') {
  loadMessages(); // Reload messages after deletion
  }
  }, 'json');
  }
  });
  }
  
  // Load messages on the messages page
  if (window.location.pathname.endsWith('messages.php')) {
  loadMessages(); // Only load messages if we are on the messages page
  }
  
  // Logout functionality
  $('#logoutButton').click(function() {
  $.get('logout.php', function() {
  window.location.href = 'login.php'; // Redirect to login page after logout
  });
  });
  });
