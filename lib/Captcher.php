<?php
namespace Lib;

class Captcher {

  /**
   * Width of captcha image
   * @var int
   */
  protected $width;
  
  /**
   * Height of captcha image
   * @var int
   */
  protected $height;
  
  /**
   * Color of captcha image in RGB
   * @var array
   */
  protected $backgroudRgb = array(255, 255, 255);
  
  /**
   * Color of captcha text (and other elements like dots and lines) in RGB
   * @var array
   */
  protected $textColor = array(0, 0, 0);
  
  /**
   * Add horizontal lines?
   * @var bool
   */
  protected $drawHorizontalLines = true;
  
  /**
   * Add vertical lines?
   * @var bool
   */
  protected $drawVerticallLines = true;
  
  /**
   * Add dots?
   * @var bool
   */
  protected $drawDots = true;
  
  /**
   * Amount of letters on image
   * @var int
   */
  protected $lettersAmount = 4;
  
  /**
   * Characters collection for Captcha text 
   * @var string
   */
  protected $characters = '23456789ABCDEFGHJKLMNPRSTVWZ';
  
  /**
   * Text for image
   * @var string
   */
  protected $captchaText = '';
  
  /**
   * Path to folder with fonts
   * @var string
   */

  // protected $fontsPath = '../fonts/';

  
  /**
   * Set width and height of captcha image
   * @param int $width
   * @param int $height
   * @throws Exception
   */
  function __construct($width, $height) {
    
    if (!extension_loaded('gd') || !function_exists('gd_info')) {
      throw new \Exception("Where's GD library? [by Captcher]");
    }    
    
    $this->width = $width;
    $this->height = $height;
    
  }
  
  /**
   * Set background color of captcha image
   * @param array $rgb Color in RGB
   */
  public function setBackgroundColor(array $rgb) {
    
    $this->backgroudRgb = $rgb;
    
  }

  /**
   * Set text color of captcha image
   * @param array $rgb Color in RGB
   */
  public function setTextColor(array $rgb) {
    
    $this->textColor = $rgb;
    
  }
  
  /**
   * Set if horizontal lines should be used
   * @param bool $do
   */
  public function setHorizontalLines($do) {
    
    $this->drawHorizontalLines = $do;
    
  }
  
  /**
   * Set if vertical lines should be used
   * @param bool $do
   */
  public function setVerticalLines($do) {
    
    $this->drawVerticallLines = $do;
    
  }
  
  /**
   * Set if dots lines should be used
   * @param bool $do
   */
  public function setDots($do) {
    
    $this->drawDots = $do;
    
  }
  
  /**
   * Set amount of letters on image
   * @param int $amount
   */
  public function setLettersAmount($amount) {
    
    $this->lettersAmount = $amount;
    
  }
  
  /**
   * Set own characters to use in captcha text generator
   * @param string $characters
   */
  public function setAvailableCharacters(string $characters) {
    
    $this->characters = $characters;
    
  }
  
  /**
   * Get text wrote on captcha image
   * @return string
   */
  public function getCaptchaText() {
    
    return $this->captchaText;
    
  }
  
  /**
   * Generate image, text and additions
   * @return decoded image
   */
  function generate() {
    
    $background = imagecreatetruecolor($this->width, $this->height);
    
    $backgroundColor = imagecolorallocate(
      $background, 
      $this->backgroudRgb[0], 
      $this->backgroudRgb[1], 
      $this->backgroudRgb[2]
    );
    
    $elemsColor = imagecolorallocate(
      $background, 
      $this->textColor[0], 
      $this->textColor[1], 
      $this->textColor[2]
    );
    
    # Add background color
    imagefill($background, 0, 0, $backgroundColor);
    
    # Add horizontal lines?
    if ($this->drawHorizontalLines) {
      for ($l=0; $l<rand(1,3); $l++) {
        imageline($background , 0, rand(0, $this->height), $this->width, rand(0, $this->height), $elemsColor);
      }
    }
    
    # Add vertical lines?
    if ($this->drawVerticallLines) {
      for ($l=0; $l<rand(1,3); $l++) {
        imageline($background , rand(0, $this->width), 0, rand(0, $this->width), $this->height, $elemsColor);
      }
    }
    
    # Add dots?
    if ($this->drawDots) {
      for($i=0;$i<500;$i++) {
          imagesetpixel($background, rand(0, $this->width),rand(0, $this->height), $elemsColor);
      }
    }
    
    $letterMarginX = $this->width / $this->lettersAmount;
    $letterMarginY = $this->height / 1.3;

    for ($i=0; $i<$this->lettersAmount; $i++) {
      
      # Margin for first letter
      if ($i===0) {
        $z = 10;
      } else {
        $z = 0;
      }
      
      $letter = $this->characters[rand(0, mb_strlen($this->characters) - 1)];
      $this->captchaText .= $letter;
      $font = $_SERVER['DOCUMENT_ROOT'] . '/lib/fonts/'. rand(0, 7) . '.ttf';
      imagettftext(
        $background,
        rand(20, 30),
        rand(-20, 20),
        ($i*$letterMarginX) + $z,
        $letterMarginY,
        $elemsColor, $font, $letter
      );
      
    }
    
    ob_start();
    imagejpeg($background, NULL, 100);
    $bytesImage = ob_get_clean();
    return $bytesImage;
    
  }
}