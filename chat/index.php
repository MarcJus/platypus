<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css">
  <title>Platypus Chat</title>
</head>
<body>
  <div class="chat-container">
    <header class="chat-header">
      <h1><i class="fas fa-platypus"></i>PlatypusChat</h1>
      <a href="/platypus" class="btn">Leave Room</a>
    </header>
    <main class="chat-main">
      <div class="chat-sidebar">
        <h3><i class="fas fa-comments"></i> Room Name:</h3>
        <h2 id="room-name">Gamers</h2>
        <h3><i class="fas fa-users"></i> Users</h3>
        <ul id="users">
          <li>User1</li>
          <li>User2</li>
          <li>User3</li>
          <li>User5</li>
          <li>User6</li>
        </ul>
      </div>
      <div class="chat-messages">
					<div class="message">
						<p class="meta">User1 <span>9:12pm</span></p>
						<p class="text">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi,
							repudiandae.
						</p>
					</div>
					<div class="message">
						<p class="meta">User2 <span>9:15pm</span></p>
						<p class="text">
							Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi,
							repudiandae.
						</p>
					</div>
      </div>
    </main>
    <div class="chat-form-container">
      <form id="chat-form" method="POST" action="">
        <input
          id="msg"
          type="text"
          placeholder="Enter Message"
          required
          autocomplete="off"
        />
        <button class="btn"><i class="fas fa-paper-plane"></i> Send</button>
      </form>
    </div>
  </div>

  <script></script>

  <style>
  
  @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

:root {
	--dark-color-a: #e88e0b;
	--dark-color-b: #e88e0b;
	--light-color: #e6e9ff;
	--success-color: #5cb85c;
	--error-color: #d9534f;
}

* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

body {
	font-family: 'Roboto', sans-serif;
	font-size: 16px;
	background: var(--light-color);
	margin: 20px;
}

ul {
	list-style: none;
}

a {
	text-decoration: none;
}

.btn {
	cursor: pointer;
	padding: 5px 15px;
	background: var(--light-color);
	color: var(--dark-color-a);
	border: 0;
	font-size: 17px;
}

/* Chat Page */

.chat-container {
	max-width: 1100px;
	background: #fff;
	margin: 30px auto;
	overflow: hidden;
}

.chat-header {
	background: var(--dark-color-a);
	color: #fff;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	padding: 15px;
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.chat-main {
	display: grid;
	grid-template-columns: 1fr 3fr;
}

.chat-sidebar {
	background: var(--dark-color-b);
	color: #fff;
	padding: 20px 20px 60px;
	overflow-y: scroll;
}

.chat-sidebar h2 {
	font-size: 20px;
	background: rgba(0, 0, 0, 0.1);
	padding: 10px;
	margin-bottom: 20px;
}

.chat-sidebar h3 {
	margin-bottom: 15px;
}

.chat-sidebar ul li {
	padding: 10px 0;
}

.chat-messages {
	padding: 30px;
	max-height: 500px;
	overflow-y: scroll;
}

.chat-messages .message {
	padding: 10px;
	margin-bottom: 15px;
	background-color: var(--light-color);
	border-radius: 5px;
}

.chat-messages .message .meta {
	font-size: 15px;
	font-weight: bold;
	color: var(--dark-color-b);
	opacity: 0.7;
	margin-bottom: 7px;
}

.chat-messages .message .meta span {
	color: #777;
}

.chat-form-container {
	padding: 20px 30px;
	background-color: var(--dark-color-a);
}

.chat-form-container form {
	display: flex;
}

.chat-form-container input[type='text'] {
	font-size: 16px;
	padding: 5px;
	height: 40px;
	flex: 1;
}

/* Join Page */
.join-container {
	max-width: 500px;
	margin: 80px auto;
	color: #fff;
}

.join-header {
	text-align: center;
	padding: 20px;
	background: var(--dark-color-a);
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}

.join-main {
	padding: 30px 40px;
	background: var(--dark-color-b);
}

.join-main p {
	margin-bottom: 20px;
}

.join-main .form-control {
	margin-bottom: 20px;
}

.join-main label {
	display: block;
	margin-bottom: 5px;
}

.join-main input[type='text'] {
	font-size: 16px;
	padding: 5px;
	height: 40px;
	width: 100%;
}

.join-main select {
	font-size: 16px;
	padding: 5px;
	height: 40px;
	width: 100%;
}

.join-main .btn {
	margin-top: 20px;
	width: 100%;
}

@media (max-width: 700px) {
	.chat-main {
		display: block;
	}

	.chat-sidebar {
		display: none;
	}
}
  
</style>

<script>
	
	// 0 lines (0 sloc) 0 Bytes 

</script>

</body>
</html>