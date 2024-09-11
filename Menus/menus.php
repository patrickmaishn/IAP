<?php
class menus{
    public function main_menu(){
        ?>
        <div class="topnav">
            <a href="./">HOME</a>
            <a href="">ABOUT</a>
            <a href="">OUR PORTFOLIO</a>
            <a href="">OUR PROJECTS</a>
            <a href="">CONTACT US</a>
            <?php $this->main_right_menu(); ?>

        </div>
        <?php
    }


    public function main_right_menu(){
       ?>
       <div class="topnav-right">
        <a href="">Sign Up</a>
        <a href="">Sign In</a>
       </div>
       <?php
    }
}