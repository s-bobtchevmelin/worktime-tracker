<template>
  <Head title="Welcome" />
  <div class="bg-image bg-gray-50 text-black/50">
    <div class="w-full min-h-screen px-6 py-4 flex flex-col justify-between">
      <header class="w-full md:flex md:mt-6">
        <div class="md:w-1/4"></div>
        <h1 class="md:w-2/4 text-center font-bold text-4xl text-white dynapuff-font">Worktime Tracker</h1>
        <nav v-if="canLogin" class="md:w-1/4 flex justify-center md:justify-end mt-6 md:mt-0">
          <SecondaryButton v-if="$page.props.auth.user">
            <Link :href="route('dashboard')">Dashboard</Link>
          </SecondaryButton>

          <template v-else>
            <SecondaryButton>
              <Link :href="route('login')">Connexion</Link>
            </SecondaryButton>

            <SecondaryButton v-if="canRegister" class="ml-3">
              <Link :href="route('register')">Inscription</Link>
            </SecondaryButton>
          </template>
        </nav>
      </header>

      <main id="landing-main" class="p-10 md:p-20 flex items-center justify-center bg-white rounded-xl mx-auto">
        <div class="w-full md:flex md:justify-between">
          <img src="../../images/welcome-clock.svg" width="300" alt="">
          <div class="md:ml-10 pt-10 md:py-10 flex flex-col justify-around text-center md:text-left">
            <p class="mb-3 md:mb-0">Gérez votre temps de travail comme un pro !</p>
            <p class="mb-3 md:mb-0">Un outil simple, efficace et sans artifices.</p>
            <p>Le petit plus ? C'est 100% gratuit !</p>
          </div>
        </div>
      </main>

      <footer class="text-center text-sm text-black">
        <a href="https://sarah-bobtchev-melin.com" target="_blank">Sarah Bobtchev Melin - 2024</a>
      </footer>
    </div>
  </div>
</template>

<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap');

.bg-image {
    background: center/110% url('../../images/welcome-bg.svg');
}

.dynapuff-font {
  font-family: "DynaPuff", system-ui;
  font-optical-sizing: auto;
  font-style: normal;
  font-variation-settings:"wdth" 100;
  font-size: xxx-large;
}

@media (min-width: 1024px) {
  #landing-main {
    width: 66%;
    max-width: 850px;
  }
}

</style>
