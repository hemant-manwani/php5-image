<?php

/**
 * image-draw-scanline
 *
 * Copyright (c) 2009-2011, Nikolay Petrovski <to.petrovski@gmail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   Image
 * @author    Nikolay Petrovski <to.petrovski@gmail.com>
 * @copyright 2009-2011 Nikolay Petrovski <to.petrovski@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @since     File available since Release 1.0.0
 */
require_once 'Image/Image.php';

require_once 'Image/Plugin/Base.php';

require_once 'Image/Plugin/Interface.php';

class Image_Draw_Scanline extends Image_Draw_Abstract implements Image_Plugin_Interface {

    public function __construct($width = 4, $color = "FFFFFF", $light_alpha = 100, $dark_alpha = 80) {
        $this->width = $width;
        $this->color = $color;
        $this->light_alpha = $light_alpha;
        $this->dark_alpha = $dark_alpha;
    }

    public function generate() {
        $alt = 0;
        imagesavealpha($this->_owner->image, true);
        imagealphablending($this->_owner->image, true);
        $arrColor = Image_Image::hexColorToArrayColor($this->color);
        $l = imagecolorallocatealpha($this->_owner->image, $arrColor['red'], $arrColor['green'], $arrColor['blue'], $this->light_alpha);
        $d = imagecolorallocatealpha($this->_owner->image, $arrColor['red'], $arrColor['green'], $arrColor['blue'], $this->dark_alpha);
        for ($x = 0; $x < $this->_owner->imagesy(); $x += $this->width) {
            if ($alt++ % 2 == 0) {
                imagefilledrectangle($this->_owner->image, 0, $x, $this->_owner->imagesx(), $x + $this->width - 1, $l);
            } else {
                imagefilledrectangle($this->_owner->image, 0, $x, $this->_owner->imagesx(), $x + $this->width - 1, $d);
            }
        }
        return true;
    }

}
