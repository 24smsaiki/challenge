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
      <h4 class="product-name">{{ product.name }}</h4>
      <p class="price">
        <span>{{ product.price }} €</span>
      </p>
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
      <a href="#" class="cart">Ajouter au panier</a>
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

<style scoped>
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

@media screen and (max-width: 750px) {
  .card-img {
    height: 40%;
  }

  .product-info {
    height: 60%;
  }
}

@media screen and (max-width: 500px) {
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
