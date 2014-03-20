<h1>Mentorship Project</h1>
<p>This project is a social platform made for students of a university. At the beginning, it was made for Marmara University students, then published as an open source project. Generally, computer engineering students use this for now. Our aim is to use for students of any department. A new student who has questions about school, campus life, teachers, and lectures is able to ask them to another student who has experience about these cases and he is called mentor. All students has been matched by considering their personality and knowledge.</p>
<p>Project has multi-language support. (English and Turkish available for now) Front-end of the project was made by using Bootstrap and back-end is full PHP with Laravel framework and MySQL database. By using benefits of Laravel, it can be connected to other database systems such as PostgreSQL, MongoDB, etc.</p>
<p>You can improve it for yourself by cloning a copy from here.</p>
<br />
<p><b>PS:</b> This project is currently used in <a href="http://www.mentormarmara.com/" target="_blank">www.mentormarmara.com</a></p>

<h1>Usage</h1>
<p>
<ul>
<li>Clone a copy of project.</li>
<li>Edit <code>index.php</code> to redirect <code>/public</code> automatically. (Optional)</li>
<br />
<li>Edit <code>app/config/app.php</code>.</li>
<li>If you are in debug mode, change <code>'debug'</code> line as <code>true</code>. Otherwise, when it is ready to publish, do not forget to change it as <code>false</code> again.</li>
<li>Main URL of project when published must be placed in <code>'url'</code> line.</li>
<br />
<li>Do not forget to change <code>'key'</code> line with yours! You can generate an app key by typing <code>php artisan key:generate</code></li>
<li>Edit <code>app/config/database.php</code> with your connection strings.</li>
<li>You can find a sample for database schema in <code>mentor_db.sql</code> file.</li>
<li>Default both username and password are <code>admin</code>. admin user is only for managing users.</li>
<li>For API usage, there is a basic API key placed in <code>app/routes.php</code>. Change this line with an API key that you have determined by yourself.</li>
<li>If you don't want to use an API, you can comment all lines after <code>// API</code>.</li>
</ul>
<br />
You are ready to use it now!
</p>
