import $ from 'jquery';

class HeroSlider {
  constructor() {
    this.els = $(".hero-slider");
    this.initSlider();
  }

  initSlider() {
    this.els.slick({
      autoplay: true,
      arrows: false,
      dots: false,
        vertical:true
    });
  }
}

export default HeroSlider;