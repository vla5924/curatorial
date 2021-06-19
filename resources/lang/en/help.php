<?php

return [
    'help' => 'Help',
    'manuals_and_faq' => 'FAQ',
    'about' => 'About',
    'curatorial_ege100' => 'Curatorial EGE100',
    'curatorial_ege100_description' => 'Centralized system for productivity improvement of the EGE100 project curators.',
    'laravel' => 'Laravel 8',
    'laravel_description' => 'Internally, curatorial is built with Laravel. This is a modern PHP framework based on MVC pattern.',
    'developer' => 'Developer',
    'developer_description_1' => 'My name is',
    'maksim_vlasov' => 'Maksim Vlasov',
    'developer_description_2' => 'and I am the one who developed the whole application you are currently using.',
    'old_points_displayed' => 'Why is the old points value displayed?',
    'old_points_displayed_answer' => 'It\'s okay, your points are not lost. In order to reduce the server load that
would occur when calculating points for each request, they are instead recalculated and cached automatically twice a day
(usually at 6: 00 and 18: 00 Moscow time).',
    'old_practices_disappear' => 'Why do old practices disappear?',
    'old_practices_disappear_answer' => 'Practices created more than 30 days ago are automatically deleted. Since each
practice is, in fact, just a set of images, with an increase in their number, they would begin to occupy a large amount
of disk space on the server, while being completely useless.',
    'n_posts_unanswered_warning' => 'How do I get rid of the "N posts unanswered" warning?',
    'n_posts_unanswered_warning_answer' => 'The "unanswered post" label is assigned by default to posts published in one
of the supported VK groups (i.e. displayed in the "Posts" section") with the practice hashtag. To get rid of the
warning, check out the list of such posts and add a group-authored comment to each of them with an answer. The comment
must contain one of the following phrases (case is not important):',
];
