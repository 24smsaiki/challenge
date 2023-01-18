<template>
  <div class="card">
          <div class="card-img">
            <img
              src="https://m.media-amazon.com/images/I/71wzZxJ0dZL._AC_SX679_.jpg"
              class="img-fluid"
              alt=""
            />
          </div>
          <div class="product-info">
            <h4 class="product-name">{{product.name}}</h4>
            <p class="price"><span>{{product.price}} €</span></p>
            <div class="rating">
              <ul class="stars">
                <li class="star">
                  <i class="fa fa-star"></i>
                </li>
                <li class="star">
                  <i class="fa fa-star"></i>
                </li>
                <li class="star">
                  <i class="fa fa-star"></i>
                </li>
                <li class="star">
                  <i class="fa fa-star"></i>
                </li>
                <li class="star">
                  <i class="fa fa-star"></i>
                </li>
                <li class="count">4,326</li>
              </ul>
            </div>
            <a href="#" class="cart">Add to Cart</a>
          </div>
        </div>
</template>

<script>
export default {
  name: "Product",
  props: { product: Object },
  computed: {
    editSrc() {
      return this.product.categoryImage.desktop.slice(2);
    },
  },
  data() {
    return {
      windowSize: null,
    };
  },
  methods: {
    setWindowSize() {
      let windowWidth = window.innerWidth;
      if (windowWidth < 768) {
        this.windowSize = "mobile";
      } else if (windowWidth < 1205) {
        this.windowSize = "tablet";
      } else {
        this.windowSize = "desktop";
      }
    },
  },
  created() {
    this.setWindowSize();
    window.addEventListener("resize", this.setWindowSize);
  },
};
</script>

<!-- <style lang="scss" scoped>
.product {
  margin: 6rem auto;
  width: 32.7rem;
  display: flex;
  flex-direction: column;
  align-items: center;

  @media (min-width: 768px) {
    width: 68.9rem;
  }

  @media (min-width: 1205px) {
    width: 111rem;
    flex-direction: row;

    &:nth-child(odd) {
      flex-direction: row-reverse;

      & .product__text {
        margin-left: 0;
        margin-right: 12.5rem;
      }
    }
  }

  & * {
    text-align: center;
  }

  &:first-child {
    margin-top: 6.4rem;
  }

  &__preview {
    width: 100%;
    border-radius: 0.8rem;
    object-fit: cover;
    object-position: center;

    @media (min-width: 768px) {
      height: 35.2rem;
    }

    @media (min-width: 1205px) {
      width: 54rem;
      height: 56rem;
    }
  }

  &__text {
    margin-top: 3.2rem;

    @media (min-width: 768px) {
      width: 57.2rem;
    }

    @media (min-width: 1205px) {
      margin: 0;
      margin-left: 12.5rem;
      width: 44.5rem;
      display: flex;
      flex-direction: column;
      align-items: flex-start;

      * {
        text-align: left;
      }
    }

    &__tag {
      font-size: 1.4rem;
      font-weight: 400;
      line-height: 1.912rem;
      letter-spacing: 1rem;
      text-transform: uppercase;
      color: rgba(216, 125, 74, 1);
    }

    &__title {
      margin: 2.4rem 0;
      font-weight: 700;
      font-size: 2.8rem;
      line-height: 3.825rem;
      letter-spacing: 0.1rem;
      text-transform: uppercase;

      @media (min-width: 768px) {
        font-size: 4rem;
        line-height: 4.4rem;
        letter-spacing: 0.143rem;
      }
    }

    &__description {
      margin-bottom: 2.4rem;
      font-weight: 500;
      font-size: 1.5rem;
      line-height: 2.5rem;
      color: #8d8d8d;
    }
  }
}
</style> -->

<style scoped>
.product-line {
  z-index: 0;
}
.messages {
  display: flex;
  align-items: center;
  justify-content: center;
}
.message {
  font-size: 1.5rem;
  margin: 0.4rem 0.5rem;
  padding: 0.3rem 3rem;
  background-color: var(--blue);
  color: white;
  text-align: center;
  -webkit-animation: heartbeat 1.5s ease-in-out infinite both;
  animation: heartbeat 1.5s ease-in-out infinite both;
  border-radius: 2rem;
  box-shadow: 0 0 20px var(--blue);
}
.underline {
  text-decoration: underline;
  text-transform: uppercase;
}
h2 {
  color: #000;
  font-size: 1.5rem;
  font-weight: 300;
  text-align: center;
  text-transform: uppercase;
  position: relative;
  margin: 1rem;
}
.discounted .highlight {
  color: var(--blue);
}
h2::after {
  content: "";
  width: 100px;
  position: absolute;
  margin: 0 auto;
  height: 4px;
  background: rgba(0, 0, 0, 0.2);
  left: 0;
  right: 0;
  bottom: -20px;
}
.carousel {
  margin: 3rem auto;
  padding: 0 2rem;
}

.carousel .carousel-item {
  min-height: 330px;
  text-align: center;
  overflow: hidden;
}
.carousel .carousel-item .img-box {
  height: 150px;
  width: 100%;
  position: relative;
}
.carousel .carousel-item img {
  max-width: 100%;
  max-height: 100%;
  display: inline-block;
  position: absolute;
  bottom: 0;
  margin: 0 auto;
  left: 0;
  right: 0;
  padding: 0.5rem;
}
.carousel .carousel-item h4 {
  font-size: 1rem;
}
.carousel .carousel-item .btn {
  border-radius: 2rem;
  font-size: 11px;
  text-transform: uppercase;
  font-weight: bold;
  background: none;
  border: 1px solid #ccc;
  padding: 0.5rem 1rem;
  margin-top: 5px;
  line-height: 16px;
}
.carousel .carousel-item .btn:hover,
.carousel .carousel-item .btn:focus {
  color: #fff;
  background: #000;
  border-color: #000;
  box-shadow: none;
}
.carousel .carousel-item .btn i {
  font-size: 1rem;
  font-weight: bold;
}
.carousel .thumb-wrapper {
  text-align: center;
}
.carousel .thumb-content {
  padding: 1rem;
}
.carousel-control-prev,
.carousel-control-next {
  height: 100px;
  width: 40px;
  margin: auto 0;
}
.carousel-control-prev i,
.carousel-control-next i {
  position: absolute;
  top: 50%;
  display: inline-block;
  z-index: 5;
  left: 0;
  right: 0;
  color: rgba(0, 0, 0, 0.8);
}

.carousel .item-price {
  font-size: 12px;
  margin: 0;
}
.carousel .item-price span {
  color: #86bd57;
  font-size: 120%;
}
.carousel-indicators {
  bottom: -40px;
}
.list-inline {
  margin: 0;
}
.star-rating i {
  font-size: 0.5rem;
  color: var(--yellow);
  margin: 0;
  padding: 0;
}
.carousel .carousel-item .btn {
  color: var(--blue);
}
.row {
  display: flex;
  justify-content: space-around;
}
.col-sm-3 {
  width: 23%;
  height: 50%;
  cursor: pointer;
  transition: 0.4s;
}
.col-sm-3:hover {
  transform: scale(1.04);
}
.discounted,
.picks {
  background-color: white;
  padding: 1rem;
  margin: 1rem 0;
}

.picks .highlight {
  color: var(--green);
}
.product-cards {
  display: flex;
  padding: 2rem 0;
  gap: 1rem;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}
.card {
  box-shadow: 0 0 5px #00000040;
  transition: 0.4s;
  cursor: pointer;
  display: flex;
  flex-wrap: wrap;
  flex-direction: row;
  width: 20%;
  height: 360px;
}
.card:hover {
  box-shadow: 0 0 10px #00000040;
  transform: scale(1.02);
}

.card-img {
  width: 200px;
  padding: 1.2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 60%;
}
.card-img img {
  width: 70%;
}
.product-info {
  display: flex;
  flex-direction: column;
  padding: 1rem;
  justify-content: center;
  align-items: flex-start;
  height: 40%;
}
.product-name {
  padding: 0;
  margin: 0;
  font-size: 1.2rem;
}
.price {
  margin: 0;
  font-size: 0.8rem;
}
.price span {
  font-size: 110%;
  color: var(--green);
}
.stars {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  justify-content: center;
  align-items: center;
}
.star {
  font-size: 0.8rem;
  color: var(--yellow);
}
.count {
  color: var(--blue);
  font-size: 0.7rem;
  padding-left: 5px;
}
.cart {
  text-decoration: none;
  color: var(--blue);
}
.refurbished .highlight {
  color: var(--yellow);
}

@media screen and (max-width: 1000px) {
  .carousel .carousel-item .img-box {
    height: 90px;
  }
  .thumb-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  .thumb-content h4 {
    font-size: 0.8rem;
  }
  .list-inline {
    display: none;
  }
  .carousel-control-next-icon,
  .carousel-control-prev-icon {
    height: 1rem;
    width: 1rem;
  }
}
@media screen and (max-width: 750px) {
  .card-img {
    height: 40%;
  }
  .product-info {
    height: 60%;
  }
  .carousel .item-price {
    font-size: 10px;
    margin: 0;
  }
  .carousel .carousel-item h4[data-v-a99e3fae] {
    font-size: 0.8rem;
  }
}
@media screen and (max-width: 500px) {
  .picks {
    margin: 0;
    padding: 0;
  }
  .product-cards {
    flex-direction: column;
  }
  .card {
    width: 80%;
    justify-content: center;
    height: 165px;
  }
  .card-img {
    width: 40%;
    height: auto;
    padding: 0;
  }
  .product-info {
    width: 60%;
    padding-right: 0.5rem;
    height: auto;
  }
}
</style>