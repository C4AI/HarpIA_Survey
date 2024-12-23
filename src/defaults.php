<?php

$defaults["numsections"] = 0;
$defaults["moodlecourse"]["numsections"] = 0;
$defaults["moodlecourse"]["newsitems"] = 0;
$defaults["frontpageloggedin"] = "5";
$defaults["frontpage"] = "";
$defaults["block_course_list_hideallcourseslink"] = "1";

$defaults["additionalhtmlhead"] = <<<'ENDSTYLE'
<style>
    /* Hide "My courses" button at the top navigation bar */
    .primary-navigation li[data-key="mycourses"] {
        display: none;
    }

    /* Hide "Dashboard" button at the top navigation bar */
    .primary-navigation li[data-key="myhome"] {
        display: none;
    }

    /* Hide notification menu (bell icon) at the top navigation bar */
    #usernavigation [data-region="popover-region"] {
        display: none;
    }

    /* Hide messaging menu (chat bubble icon) at the top navigation bar */
    #usernavigation [data-region="popover-region-messages"] {
        display: none;
    }

    /* Disable the "HarpIA" link at the top navigation bar */
    .navbar-brand { 
        pointer-events: none;
    }

    /* Hide "Grades" item in the profile menu */
    #carousel-item-main a[href*="/moodle/grade/report/overview/index.php"] {
        display: none;
    }

    /* Hide "Calendar" item in the profile menu */ 
    #carousel-item-main a[href*="moodle/calendar/view.php"] {
        display: none;
    }

    /* Hide "Private files" item in the profile menu */ 
    #carousel-item-main a[href*="moodle/user/files.php"] {
        display: none;
    }

    /* Hide "Reports" item in the profile menu */ 
    #carousel-item-main a[href*="moodle/reportbuilder/index.php"] {
        display: none;
    }

    /* Hide course tabs for students (and teachers while not in edit mode) */
    body:not(.editing) .secondary-navigation {
        display: none;
    }

    /* Hide "All courses" button for students (and teachers while not in edit mode) */
    body:not(.editing) #frontpage-course-list a[href*="moodle/course/index.php"] {
        display: none;
    }

    /* Hide "My courses" title for students (and teachers while not in edit mode) */
    body:not(.editing) #frontpage-course-list h2 {
        display: none;
    }
</style>
ENDSTYLE;
