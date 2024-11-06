<template>
  <Head title="Welcome" />
  <div class="bg-image bg-gray-50 text-black/50">
    <div class="w-full min-h-screen px-6 py-4 flex flex-col justify-between">
      <header class="w-full flex mt-6">
        <div class="w-1/4"></div>
        <h1 class="w-2/4 text-center font-bold text-4xl text-white dynapuff-font">Worktime Tracker</h1>
        <nav v-if="canLogin" class="w-1/4 flex flex-1 justify-end">
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

      <main class="p-20 flex items-center justify-center bg-white rounded-xl mx-auto" style="width: 66%; max-width: 850px;">
        <div class="w-full flex justify-between">
          <img src="../../images/welcome-clock.svg" width="300" alt="">
          <div class="ml-10 py-10 flex flex-col justify-around">
            <p>Gérez votre temps de travail comme un pro !</p>
            <p>Un outil simple, efficace et sans artifices.</p>
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
</style>
