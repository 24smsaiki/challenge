<template>
  <section class="about">
    <div class="about__image"></div>
    <div class="about__text">
      <h2 class="about__text__heading">
        <span>GadjetMarket</span> vous apportera
        <span>les meilleurs</span> produits
      </h2>
      <p class="about__text__description">
        Situé au cœur de New York, GadjetMarket est le premier magasin pour
        casques, écouteurs, haut-parleurs et accessoires audio haut de gamme et
        tout autre type de produit quelconques. Nous avoir une grande salle
        d'exposition et des salles de démonstration de luxe à votre disposition
        pour parcourir et découvrir une large gamme de nos produits.
        Arrêtez-vous dans notre magasin pour rencontrer certaines des personnes
        fantastiques qui font de GadjetMarket le meilleur endroit pour acheter
        votre équipement.
      </p>
    </div>
  </section>
</template>

<script>
export default {
  name: "AboutSection",
};
</script>

<style lang="scss" scoped>
.about {
  margin: 5rem auto;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 32.7rem;

  @media (min-width: 768px) {
    margin: 9.6rem auto;
    width: 68.9rem;
  }

  @media (min-width: 1205px) {
    width: 111rem;
    margin: 10rem auto;
    flex-direction: row-reverse;
    justify-content: space-between;
    align-items: center;
  }

  &__image {
    width: 100%;
    border-radius: 0.8rem;
    background: url("../../assets/shared/mobile/image-best-gear.jpg");
    background-size: cover;
    background-position: top center;
    height: 30rem;

    @media (min-width: 768px) {
      background: url("../../assets/shared/tablet/image-best-gear.jpg");
      background-size: cover;
      background-position: center;
    }

    @media (min-width: 1205px) {
      width: 54rem;
      height: 58.8rem;
      background: url("../../assets/shared/desktop/image-best-gear.jpg");
      background-size: cover;
      background-position: center;
    }
  }

  &__text {
    @media (min-width: 1205px) {
      & * {
        text-align: left;
      }
    }

    &__heading {
      margin-top: 4rem;
      text-transform: uppercase;
      font-weight: 700;
      font-size: 2.8rem;
      line-height: 3.825rem;
      letter-spacing: 0.1rem;

      @media (min-width: 768px) {
        font-size: 4rem;
        line-height: 4.4rem;
        letter-spacing: 0.143rem;
        width: 57.3rem;
        margin-top: 6.3rem;
      }

      @media (min-width: 1205px) {
        width: 44.5rem;
        margin-top: 0;
      }

      & span {
        color: #d87d4a;
      }
    }

    &__description {
      margin-top: 3.2rem;
      font-weight: 500;
      font-size: 1.5rem;
      line-height: 2.5rem;
      color: #7d7d7d;

      @media (min-width: 768px) {
        width: 57.3rem;
      }

      @media (min-width: 1205px) {
        width: 44.5rem;
      }
    }
  }
}
</style>
