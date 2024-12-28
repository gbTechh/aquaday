<?php
if (is_product()) {
    get_template_part('template-parts/header/header', 'product');
} else {
    get_template_part('template-parts/header/header', 'default');
}