<?php

function getImg3($alt = "", $height = "", $width = "")
{
    return "<img src='$GLOBALS[root]/$width/$height' alt='$alt' width='$width' height='$height'/>";
}
