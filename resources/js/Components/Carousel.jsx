import Slider from 'react-slick';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

function Carousel({data}) {
  const settings = {
    dots: true,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1
  };

    return (
      <div style={{height:'60vh', overflowX: 'hidden'}} >
    <Slider {...settings}>
      <div className='flex justify-center' style={{ width: '100%', height: 'auto', objectFit:'cover' }} >
        <img src={asset('1.jpeg')} alt="Slide 1" />
      </div>
      <div>
        <img src={asset('1.jpeg')} alt="Slide 1" />
      </div>
      {/* Add more slides as needed */}
            </Slider>
            </div>
  );
}

const asset = (path) => {
    return `/storage/images/${path}`;
}

export default Carousel;
