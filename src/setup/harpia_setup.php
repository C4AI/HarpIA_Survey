<?php

function generate_random_password()
{
    $alpha_num = implode('', array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9)));
    $symb = '_';
    $all = $alpha_num . $symb;

    $part1 = implode('', array_map(function () use ($alpha_num) {
        return $alpha_num[rand(0, strlen($alpha_num) - 1)];
    }, range(1, 16)));
    $part2 = implode('', array_map(function () use ($symb) {
        return $symb[rand(0, strlen($symb) - 1)];
    }, range(1, 4)));
    $part3 = implode('', array_map(function () use ($all) {
        return $all[rand(0, strlen($all) - 1)];
    }, range(1, 8)));

    return str_shuffle($part1 . $part2 . $part3);
}

function exit_with_error()
{
    echo ">>>> FAILED. Please inspect the output above and try again.";
    exit(1);
}

$harpia_data = "/harpia/data/";
$moodle_data = "$harpia_data/moodledata";
$target_config_php_path = "$harpia_data/config.php";
$moodle_repo_path = getenv('MOODLEREPOPATH');

if (is_dir($target_config_php_path)) {
    echo "ERROR: There is a spurious 'config.php' subdirectory in your data directory.\n";
    echo "Please delete it and try again.\n";
    exit_with_error();
}


# Read options from command-line
$options = getopt("", ["admin-user:", "admin-pass:", "www-root:"]);

if (!isset($options['admin-user']) || !isset($options['www-root'])) {
    echo "Usage: php harpia_setup.php --admin-user='<username>' --www-root='<address>'\n";
    exit_with_error();
}

# Admin user to be created automatically
$admin_user = $options['admin-user'];
echo "Type the password for the admin user '$admin_user':\n";
$admin_pass = rtrim(fgets(STDIN), "\n");
if (strlen($admin_pass) === 0) {
    echo "Password cannot be empty.";
    exit_with_error();
}

# Website name
$full_name = 'HarpIA Survey';
$short_name = 'HarpIA Survey';

# Website address
$www_root = $options['www-root'];

# Language
$lang = 'en';

# Dabatase
$db_type = 'mariadb';
$db_user = 'harpiamoodleuser';
$db_pass = generate_random_password();

echo "\n\n====== SETTING UP DATABASE ======\n\n";
$process = proc_open(["mariadb-install-db", "--user=mysql"], [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();

$process = proc_open(["service", $db_type, "start"], [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();

$sql_lines = [
    "CREATE DATABASE moodle DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;",
    "CREATE USER '$db_user'@'localhost' IDENTIFIED BY '$db_pass';",
    "GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, CREATE TEMPORARY TABLES, DROP, INDEX, ALTER ON moodle.* TO '$db_user'@'localhost';",
    "FLUSH PRIVILEGES;"
];
foreach ($sql_lines as $sql) {
    $process = proc_open(["mariadb", "-e", $sql], [], $pipes);
    $ret = proc_close($process);
    if ($ret !== 0)
        exit_with_error();
}

echo "\n\n====== APPLYING PERMISSIONS BEFORE INSTALLATION ======\n\n";
$process = proc_open(["chown", "-v", "www-data", $moodle_repo_path, $harpia_data], [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();


echo "\n\n====== INSTALLING MOODLE ======\n\n";

$process = proc_open(
    [
        "sudo",
        "-u",
        "www-data",
        PHP_BINARY,
        "$moodle_repo_path/admin/cli/install.php",
        '--non-interactive',
        '--agree-license',
        '--allow-unstable',
        "--dbhost=127.0.0.1",
        "--dbtype=$db_type",
        "--dbuser=$db_user",
        "--dbpass=$db_pass",
        "--fullname=$full_name",
        "--shortname=$short_name",
        "--wwwroot=$www_root",
        "--adminuser=$admin_user",
        "--adminpass=$admin_pass",
        "--dataroot=$moodle_data",
    ],
    [],
    $pipes
);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();

echo "\n\n====== INSTALLING LANGUAGE PACKS ======\n\n\n";
$languages = ["pt_br"];
$orig_script = "/harpia/src/install_lang.sh";
$fixed_script = "/tmp/install_lang.sh";
# Remove \r, which Git for Windows inserts automatically and Bash does not support
file_put_contents(
    $fixed_script,
    str_replace("\r\n", "\n", file_get_contents($orig_script))
);
$process = proc_open(array_merge(["bash", $fixed_script], $languages), [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();

echo "\n\n====== OVERRIDING TRANSLATIONS ======\n\n\n";
$languages = ["pt_br", "en"];
foreach ($languages as $lang) {
    $process = proc_open(["cp", "-r", "/harpia/custom_translations/{$lang}_local", "$moodle_data/lang/"], [], $pipes);
    $ret = proc_close($process);
    if ($ret !== 0)
        exit_with_error();
}

echo "\n\n====== CHANGING DEFAULT VALUES ======\n\n\n";
$sql_lines = [
    "UPDATE mdl_tool_usertours_tours SET enabled=0;"
];
foreach ($sql_lines as $sql) {
    $process = proc_open(["mariadb", "-e", "USE moodle; $sql"], [], $pipes);
    $ret = proc_close($process);
    if ($ret !== 0)
        exit_with_error();
}


echo "\n\n====== APPLYING PERMISSIONS AFTER INSTALLATION ======\n\n";
$config_php_path = "$moodle_repo_path/config.php";

$process = proc_open(["chmod", "-v", "+r", $config_php_path], [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();

$process = proc_open(["chown", "-v", "root", $config_php_path], [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();

echo "\n\n====== COPYING CONFIGURATION ======\n\n";
$process = proc_open(["mv", "-v", $config_php_path, $target_config_php_path], [], $pipes);
$ret = proc_close($process);
if ($ret !== 0)
    exit_with_error();


echo "\n\n====== SUCCESS! ======\n\n";
