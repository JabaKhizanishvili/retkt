import Slider from 'react-slick';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

function Carousel({data}) {
  const settings = {
    dots: true,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: true,
    className: 'slides',
  };

     return (
    <div className="carousel-container"  >
      <Slider {...settings}>
        <div className="slide">
          <img src={asset('1.jpg')} alt="Slide 1" />
        </div>
        <div className="slide">
          <img src={asset('1.jpg')} alt="Slide 2" />
        </div>
      </Slider>
    </div>
  );

   return (
        <div className='bg-red-100' style={{ height: '65vh', overflow: 'hidden' }}>
            <Slider {...settings} >
            <div style={{ height: '100%' }}>
                <img src={asset('1.jpg')} alt="Slide 1" style={{ objectFit: 'contain', width: '100%', height: '100%', overflow: 'hidden' }} />
            </div>
            <div style={{ height: '100%' }}>
                <img src={asset('1.jpg')} alt="Slide 1" style={{ objectFit: 'contain', width: '100%', height: '100%', overflow: 'hidden' }} />
            </div>
            </Slider>
        </div>
   );

}

const asset = (path) => {
    return `/storage/images/${path}`;
}

export default Carousel;
