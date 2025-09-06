<script setup lang="ts">
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import PlaceholderPattern from "@/components/PlaceholderPattern.vue";
import { defineAsyncComponent } from "vue";

const WelcomeLayout = defineAsyncComponent(() => import("@/layouts/WelcomeLayout.vue"));
const showCookies = ref(true);

// ✅ Initialize page first
const page = usePage();
const user = page.props.auth?.user ?? null;

// ✅ Props
const props = defineProps<{
  products: {
    created_at: string;
  } | null;
  totalUsers: number;
  branchType?: string | null;  // <-- optional, in case it's undefined
}>();

// ✅ Format product date
const formattedDate = props.products
  ? new Date(props.products.created_at).toLocaleString("en-US", {
      year: "numeric",
      month: "long",
      day: "numeric",
      hour: "numeric",
      minute: "2-digit",
      hour12: true,
    })
  : "No products available";

// ✅ Computed dashboard link
const dashboardLink = computed(() => {
  if (!user) return null;
  switch (user.role) {
    case "OwnerAdmin":
      return "/owneradmin/dashboard";
    case "Manager":
      return "/manager/dashboard";
    case "StaffRetail":
      return "/staffpanel/staffretail/Dashboard"; 
    case "StaffRestaurant":
      return "/staffpanel/staffrestaurant/Dashboard";
    case "StaffSalon":
      return "/staffpanel/staffsalon/Dashboard";
 case "AdminControl":
      return "/admincontrol/dashboard";
    default:
      return null;
  }
});

// ✅ Cookie logic
onMounted(() => {
  const dismissed = localStorage.getItem("cookiesDismissed");
  if (dismissed === "true") {
    showCookies.value = false;
  }
});

function dismissCookies() {
  localStorage.setItem("cookiesDismissed", "true");
  showCookies.value = false;
}
</script>




<style scoped>
      img {
  filter: drop-shadow(1px 1px 2px black);
}
</style>
<template>
  <Head title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>
  <Suspense>
    <WelcomeLayout>



      <div
        class="flex min-h-screen flex-col items-centerbg-white dark:bg-gray-900 p-6 text-[#1b1b18] lg:justify-center lg:p-8"
      >
       <nav
  class="fixed w-full top-0 z-50 bg-white dark:bg-gray-900 backdrop-blur-lg transition-colors duration-300 md:px-10 lg:px-10"
>
  <div class="container mx-auto flex h-20 items-center justify-between px-4">
    <!-- Logo and Home Link -->
    <a href="/" class="flex items-center shrink-0">
   <!-- <img
  src="../assets/img/logo/sam.png"
  alt="Anggot Business Portal logo"
  style="width: 150px; height: auto"
/> -->

<img src="../assets/img/logo/sam.png" class="dark:hidden"   style="width: 150px; height: auto" alt="Anggot Logo">

<!-- Dark mode -->
<img src="../assets/img/logo/sam.png" class="hidden dark:inline"   style="width: 150px; height: auto" alt="Anggot Logo">
      <!-- <span class="md:flex text-2xl mt-0.5 font-bold ml-1 text-black dark:text-white">
        Business Portal
      </span> -->
    </a>

    <!-- Desktop Menu Links -->
    <div class="hidden md:flex items-center md:gap-8 font-bold text-black dark:text-white">
      <a href="/" class="text-sm hover:text-purple-400 transition">Home</a>
      <a href="#about" class="text-sm hover:text-purple-400 transition">About</a>
      <a href="#services" class="text-sm hover:text-purple-400 transition">Services</a>
      <a href="#contact" class="text-sm hover:text-purple-400 transition">Contact</a>

  <Link
    v-if="dashboardLink"
    :href="dashboardLink"
    class="cursor-pointer rounded-full border-2 py-2 px-6 border-purple-900 bg-white dark:bg-gray-800 text-purple-900 dark:text-white hover:bg-purple-900 hover:text-white hover:shadow-lg transition duration-300 ease-in-out"
  >
    Dashboard
  </Link>

<template v-if="!user">
  <Link
    :href="route('login')"
    class="cursor-pointer rounded-full border-2 py-2 px-6 border-purple-900 bg-white dark:bg-gray-800 text-purple-900 dark:text-white hover:bg-purple-900 hover:text-white hover:shadow-lg transition duration-300 ease-in-out"
  >
    Log in
  </Link>
  <Link
    :href="route('register')"
    class=" cursor-pointer rounded-full border-2 py-2 px-6 border-purple-900 bg-white dark:bg-gray-800 text-purple-900 dark:text-white hover:bg-purple-900 hover:text-white hover:shadow-lg transition duration-300 ease-in-out"
  >
    Register
  </Link>
</template>

    </div>
    <!-- Mobile Menu Button -->
    <div class="md:hidden">
      <button class="text-2xl text-black dark:text-white" onclick="setIsMenuOpen(!isMenuOpen)">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4 6h16M4 12h16M4 18h16"
          />
        </svg>
      </button>
    </div>
  </div>
</nav>

        <!-- Middle Section -->
        <section
          class="w-full flex items-center justify-center min-h-screen overflow-hidden bg-gradient-to-b to-purple-800 "
        >
          <!-- Overlay for better text visibility -->
          <div class="absolute inset-0 bg-opacity-50"></div>

          <!-- Content -->
          <div class="relative z-10 container mx-auto px-4 text-center text-white">
            <h1
              class="mb-6 text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl"
              style="line-height: 1.2"
            >
             Powering
              <span
                class="relative whitespace-nowrap text-purple-400 dark:text-purple-400"
              >
                <svg
                  aria-hidden="true"
                  viewBox="0 0 418 42"
                  class="absolute top-2/3 left-0 h-[0.58em] w-full fill-purple-400/70 dark:fill-purple-300/60"
                  preserveAspectRatio="none"
                >
                  <path
                    d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.780 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.540-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.810 23.239-7.825 27.934-10.149 28.304-14.005 .417-4.348-3.529-6-16.878-7.066Z"
                  ></path>
                </svg>
                <span class="relative">Business</span>
              </span>
              Efficiency
            </h1>
            <p class="mx-auto mb-8 max-w-2xl text-lg">
             POSify is a cloud-based Point of Sale system designed for businesses like
    retail stores, restaurants, and salons. Manage sales, inventory, staff, and
    reports securely—anytime, anywhere.
            </p>

            <!-- CTA Button -->
            <div
              class="flex justify-center items-center mt-8"
              data-aos="fade-up"
              data-aos-delay="400"
            >
              <a
                href="#pricing"
                rel="noopener noreferrer"
                class="relative flex items-center justify-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white text-lg font-semibold rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200"
              >
                <span
                  class="absolute inset-0 rounded-full bg-purple-600 opacity-50 animate-ping"
                ></span>
                <span class="relative z-10 pr-2">Explore Features</span>
              </a>
            </div>
          </div>

          <!-- Scroll Down Icon -->
          <div
            class="absolute sm:bottom-14 bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce"
          >
            <a href="#about" class="cursor-pointer">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-10 w-10 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </a>
          </div>
        </section>

    <div class="relative bg-blue-600 w-full">
  <!-- SVG background adapts to dark mode -->
  <div class="absolute inset-x-0 bottom-0">
    <svg
      viewBox="0 0 224 12"
      fill="currentColor"
      class="w-full -mb-1 text-white dark:text-gray-900"
      preserveAspectRatio="none"
    >
      <path
        d="M0,0 C48.8902582,6.27314026 86.2235915,9.40971039 112,9.40971039 C137.776408,9.40971039 175.109742,6.27314026 224,0 L224,12.0441132 L0,12.0441132 L0,0 Z"
      ></path>
    </svg>
  </div>

  <!-- Section content -->
  <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
    <div class="relative max-w-2xl sm:mx-auto sm:max-w-xl md:max-w-2xl sm:text-center">
      <h2 class="mb-6 font-sans text-3xl font-bold tracking-tight text-center text-white dark:text-gray-100 sm:text-4xl sm:leading-none">
        Total User This Year
      </h2>

      <p class="mb-6 text-5xl font-bold text-center text-indigo-200 dark:text-indigo-300 md:text-6xl" id="animated-number">
        {{ totalUsers }}
      </p>

      <p class="mb-6 text-base text-center text-indigo-200 dark:text-indigo-300 md:text-lg" id="currentDate">
      </p>
    </div>
  </div>
</div>
 <div class="bg-gradient-to-r bg-white py-12 px-4 dark:bg-gray-900">
      <div class="max-w-screen-xl mx-auto">
        <div class="max-w-3xl mx-auto mb-16 text-center">
          <h2 class="text-black text-3xl lg:text-4xl font-bold text-center mb-4 leading-relaxed dark:text-white">Discover Our Exclusive Features</h2>
          <p class="text-gray-500 group-hover:text-gray-800 text-base leading-relaxed dark:text-slate-300">Unlock a world of possibilities with our exclusive features. Explore how our unique offerings can transform your journey and empower you to achieve more.</p>
        </div>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 mx-auto">
        <div class="rounded-xl group p-8 text-center bg-white  hover:bg-gray-100 hover:shadow-xl transition duration-300 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
  <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 mb-6 inline-block text-blue-800" viewBox="0 0 100 100">
    <path d="M65.156 4.42c-8.327 0-15.13 6.855-15.13 15.202s6.803 15.165 15.13 15.165c7.017 0 12.924-4.863 14.626-11.382h13.843a3.798 3.798 0 0 0 3.791-3.805 3.798 3.798 0 0 0-3.79-3.8h-13.86C78.053 9.294 72.16 4.42 65.156 4.42zM6.391 15.8a3.798 3.798 0 0 0-3.79 3.805 3.798 3.798 0 0 0 3.79 3.8h36.397c-.21-1.234-.348-2.493-.348-3.783 0-1.304.134-2.575.348-3.821zm28.47 18.987c-7.018 0-12.92 4.89-14.619 11.418H6.392a3.783 3.783 0 0 0-.363 0 3.801 3.801 0 0 0-3.52 4.062 3.798 3.798 0 0 0 3.882 3.535H20.25c1.71 6.511 7.604 11.382 14.61 11.382 8.328 0 15.167-6.848 15.167-15.195 0-8.347-6.84-15.202-15.166-15.202zm22.383 11.418c.21 1.234.347 2.494.347 3.784 0 1.3-.134 2.57-.347 3.813h36.381a3.795 3.795 0 0 0 3.874-3.714 3.796 3.796 0 0 0-3.874-3.883H57.244zm7.912 18.979c-8.327 0-15.13 6.855-15.13 15.202S56.83 95.58 65.157 95.58c7.007 0 12.907-4.87 14.618-11.382h13.851a3.796 3.796 0 0 0 3.706-3.883 3.795 3.795 0 0 0-3.706-3.714H79.782c-1.701-6.527-7.608-11.418-14.626-11.418zM6.029 76.602a3.801 3.801 0 0 0-3.52 4.062 3.798 3.798 0 0 0 3.882 3.535h36.412a22.541 22.541 0 0 1-.348-3.813c0-1.29.138-2.55.348-3.784H6.39a3.783 3.783 0 0 0-.362 0z" />
  </svg>
  <h3 class="text-lg font-semibold mb-3 text-black dark:text-white">Customization</h3>
  <p class="text-gray-600  text-base leading-relaxed dark:text-slate-300 dark:group-hover:text-white ">
    Easily tailor every aspect of the platform to suit your business needs. From design tweaks to functional preferences and operate.
  </p>
</div>


         <div class="rounded-xl group p-8 text-center bg-white  hover:bg-gray-100 hover:shadow-xl transition duration-300 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 mb-6 inline-block text-pink-800" viewBox="0 0 682.667 682.667">
              <defs>
                <clipPath id="b" clipPathUnits="userSpaceOnUse">
                  <path d="M0 512h512V0H0Z" data-original="#000000" />
                </clipPath>
              </defs>
              <mask id="a">
                <rect width="100%" height="100%" fill="#fff" data-original="#ffffff" />
              </mask>
              <g mask="url(#a)">
                <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="30" clip-path="url(#b)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                  <path d="M458.172 372.633a533.882 533.882 0 0 0-.474 16.345c-.303 20.475-16.411 37.184-36.856 38.326-62.529 3.493-111.431 24.292-152.737 64.553-6.912 6.336-17.279 6.336-24.191 0-41.306-40.261-90.208-61.06-152.737-64.553-20.445-1.142-36.553-17.851-36.857-38.325a530.642 530.642 0 0 0-.473-16.346C51.549 251.97 48.104 86.598 248.803 16.615a22.014 22.014 0 0 1 2.942-.801l.01-.002a21.72 21.72 0 0 1 8.509 0c1.002.2 1.996.47 2.961.807C463.342 86.602 460.47 251.398 458.172 372.633Z" data-original="#000000" />
                  <path d="M368.408 256c0-62.082-50.327-112.409-112.408-112.409S143.592 193.918 143.592 256c0 62.082 50.327 112.409 112.408 112.409S368.408 318.082 368.408 256Z" data-original="#000000" />
                  <path stroke-linecap="round" d="m303.227 284.952-69.785-69.785M206.773 241.834l26.668-26.668" data-original="#000000" />
                </g>
              </g>
            </svg>
   <h3 class="text-lg font-semibold mb-3 text-black dark:text-white">Security</h3>
  <p class="text-gray-600  text-base leading-relaxed dark:text-slate-300 dark:group-hover:text-white">Your privacy is our top priority. We implement industry-standard encryption and real-time threat detection to keep your data safe.</p>
          </div>

                  <div class="rounded-xl group p-8 text-center bg-white  hover:bg-gray-100 hover:shadow-xl transition duration-300 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 mb-6 inline-block text-green-800" viewBox="0 0 512 512">
              <path d="M495.984 252.588c-17.119-14.109-44.177-15.319-61.936 3.74l-44.087 47.327c-5.7-18.319-22.809-31.658-42.977-31.658h-78.675c-5.97 0-7.969-2.28-18.339-10.269-39.538-34.468-98.924-34.358-138.342.33L82.71 287.516c-12.999-6.88-28.178-7.05-41.248-.52L8.294 303.575c-7.41 3.71-10.409 12.719-6.71 20.129l89.995 179.989c3.71 7.41 12.719 10.409 20.129 6.71l33.168-16.589c16.349-8.169 25.448-24.849 24.858-41.827h177.249c32.868 0 64.276-15.699 83.995-41.997l72.006-96.014c13.969-18.61 11.759-45.899-7-61.388zM131.456 466.985l-19.749 9.879-76.585-153.16 19.759-9.879c7.41-3.7 16.409-.71 20.119 6.71l63.166 126.332c3.7 7.409.7 16.408-6.71 20.118zm347.529-171.009L406.98 391.99c-14.089 18.789-36.518 29.998-59.996 29.998H159.265l-56.207-112.423 28.388-24.988c28.248-24.849 70.846-24.849 99.094 0 16.639 14.649 26.988 17.419 37.768 17.419h78.675c8.27 0 14.999 6.73 14.999 14.999s-6.73 14.999-14.999 14.999h-76.605c-8.28 0-14.999 6.72-14.999 14.999s6.72 14.999 14.999 14.999h86.655c12.449 0 24.449-5.22 32.928-14.329l66.036-70.886c6.04-6.48 15.299-5.94 20.979-.97 5.939 5.199 6.58 14.089 2.009 20.169zm-163.6-193.609c10.269-10.769 16.599-25.328 16.599-41.358 0-33.018-26.678-60.996-59.996-60.996-33.068 0-60.996 27.928-60.996 60.996 0 15.539 6.09 30.208 17.149 41.478-27.428 15.379-47.147 44.897-47.147 79.515v14.999c0 8.279 6.72 14.999 14.999 14.999h150.991c8.279 0 14.999-6.72 14.999-14.999v-14.999c-.001-33.938-18.668-63.916-46.598-79.635zm-43.397-72.355c16.259 0 29.998 14.199 29.998 30.998 0 16.539-13.459 29.998-29.998 29.998-16.799 0-30.998-13.739-30.998-29.998 0-16.509 14.489-30.998 30.998-30.998zm-60.996 151.99c0-33.068 27.928-60.996 60.996-60.996 33.078 0 59.996 27.358 59.996 60.996H210.992z" data-original="#000000" />
            </svg>
        <h3 class="text-lg font-semibold mb-3 text-black dark:text-white">Support</h3>
            <p class="text-gray-600  text-base leading-relaxed dark:text-slate-300 dark:group-hover:text-white">
  Our expert support team is available around the clock to assist you. we’re here to ensure your experience remains smooth.</p>
          </div>

               <div class="rounded-xl group p-8 text-center bg-white  hover:bg-gray-100 hover:shadow-xl transition duration-300 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 mb-6 inline-block text-purple-800" viewBox="0 0 512 512">
              <path d="M451 257v215c0 22.5-14.1 40-32.1 40H375c-18 0-32.1-17.6-32.1-40V257c0-22.5 14.1-40 32.1-40h43.9c17.9 0 32.1 17.6 32.1 40zm.7-126.1c-3 2.1-6.9 2.2-10.1.3l-30-18C362.2 195 292.5 272 157.9 272c-28.4 0-59.7-3.4-94.3-11-5-1.1-8.2-6-7.2-11.1 1-4.6 5.2-7.7 9.9-7.3 8.4.7 203.6 13.8 285.6-166.7L321.2 61c-4.6-2.2-6.6-7.8-4.4-12.4 1-2.1 2.7-3.7 4.8-4.6L423.5.7c4.7-2 10.2.2 12.2 4.9.3.7.5 1.4.6 2.1l19.3 113.9c.7 3.6-.9 7.3-3.9 9.3zM310.1 336v136c0 22.5-14.1 40-32.1 40h-44c-18 0-32.1-17.6-32.1-40V336c0-22.5 14.1-40 32.1-40h43.9c18.1-.1 32.2 17.5 32.2 40zm-137.8 65.8V472c0 22.4-14.1 40-32.1 40h-44c-18 0-32.1-17.6-32.1-40v-70.2c0-22.5 14.1-40 32.1-40h43.9c18.1-.1 32.2 17.5 32.2 40z" data-original="#000000" />
            </svg>
 <h3 class="text-lg font-semibold mb-3 text-black dark:text-white">Performance</h3>
          <p class="text-gray-600  text-base leading-relaxed dark:text-slate-300 dark:group-hover:text-white">
  Experience lightning-fast load times and seamless performance. Our system is built to deliver results without lag or disruption.</p>
          </div>

        <div class="rounded-xl group p-8 text-center bg-white  hover:bg-gray-100 hover:shadow-xl transition duration-300 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 mb-6 inline-block text-orange-800" viewBox="0 0 682.667 682.667">
              <defs>
                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                  <path d="M0 512h512V0H0Z" data-original="#000000" />
                </clipPath>
              </defs>
              <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="30" clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                <path d="M75 467c0-16.568-13.432-30-30-30-16.568 0-30 13.432-30 30 0 16.568 13.432 30 30 30 16.568 0 30-13.432 30-30ZM75 45c0-16.568-13.432-30-30-30-16.568 0-30 13.432-30 30 0 16.568 13.432 30 30 30 16.568 0 30-13.432 30-30ZM497 467c0-16.568-13.432-30-30-30-16.568 0-30 13.432-30 30 0 16.568 13.432 30 30 30 16.568 0 30-13.432 30-30ZM497 45c0-16.568-13.432-30-30-30-16.568 0-30 13.432-30 30 0 16.568 13.432 30 30 30 16.568 0 30-13.432 30-30ZM406 256c0-82.843-67.157-150-150-150s-150 67.157-150 150 67.157 150 150 150 150-67.157 150-150Z" data-original="#000000" />
                <path d="M316 256c0-82.843-26.863-150-60-150s-60 67.157-60 150 26.863 150 60 150 60-67.157 60-150ZM106 256h300M66.213 445.787l83.721-83.721M445.787 445.787l-83.721-83.721M362.066 149.934l83.721-83.721M149.934 149.934 66.213 66.213" data-original="#000000" />
              </g>
            </svg>
 <h3 class="text-lg font-semibold mb-3 text-black dark:text-white">Global Reach</h3>
  <p class="text-gray-600  text-base leading-relaxed dark:text-slate-300 dark:group-hover:text-white">
  Whether you're a startup or enterprise. Add users, features, or capabilities without disrupting performance.</p>
          </div>

        <div class="rounded-xl group p-8 text-center bg-white  hover:bg-gray-100 hover:shadow-xl transition duration-300 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 mb-6 inline-block text-blue-800" viewBox="0 0 682.667 682.667">
              <defs>
                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                  <path d="M0 512h512V0H0Z" data-original="#000000" />
                </clipPath>
              </defs>
              <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="30" clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                <path d="M226 15v60c0 16.568-13.432 30-30 30H76c-16.568 0-30-13.432-30-30V15Zm-45 165c0-24.853-20.147-45-45-45s-45 20.147-45 45 20.147 45 45 45 45-20.147 45-45ZM466 15v60c0 16.568-13.432 30-30 30H316c-16.568 0-30-13.432-30-30V15Zm-45 165c0-24.853-20.147-45-45-45s-45 20.147-45 45 20.147 45 45 45 45-20.147 45-45Zm-75 167v-50.294L286 347h-60.002L166 296.706V347h-15c-41.421 0-75 33.579-75 75s33.579 75 75 75h210c41.421 0 75-33.579 75-75s-33.579-75-75-75Zm-105 75h30m-90 0h30m90 0h30" data-original="#000000" />
              </g>
            </svg>
    <h3 class="text-lg font-semibold mb-3 text-black dark:text-white">Communication</h3>
        <p class="text-gray-600  text-base leading-relaxed dark:text-slate-300 dark:group-hover:text-white">
  Tailor our product to suit your needs Seamless communication for your team.</p>
          </div>
        </div>
      </div>
    </div>
<section

class="bg-white dark:bg-gray-900 py-12">
  <div  class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 
      class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl">
        Pricing Plans
      </h2>
      <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
        Simple, transparent pricing for your business needs.
      </p>
    </div>

    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <!-- Free Plan -->
   <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition duration-300">
        <div class="mb-8">
       <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Free</h3>
          <p class="mt-4 text-gray-600 dark:text-gray-400">Get started with our basic features.</p>
        </div>
          <div class="mb-8">
          <span class="text-5xl font-extrabold text-gray-900 dark:text-white">₱0</span>
          <span class="text-xl font-medium text-gray-600 dark:text-gray-400">/1 week</span>
        </div>
        <ul class="mb-8 space-y-4 text-gray-400">
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>1 user account</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>10 transactions per month</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Basic support</span>
          </li>
        </ul>
        <a href="#" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
          Sign Up
        </a>
      </div>

      <!-- Starter Plan -->
         <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition duration-300">
        <div class="mb-8">
          <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Starter</h3>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Perfect for small businesses and startups.</p>
        </div>
        <div class="mb-8">
          <span class="text-5xl font-extrabold text-gray-900 dark:text-white">₱49</span>
          <span class="text-xl font-medium text-gray-600 dark:text-gray-400">/1 month</span>
        </div>
        <ul class="mb-8 space-y-4 text-gray-400">
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>5 user accounts</span>
          </li>
           <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>100 transactions per month</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Standard support</span>
          </li>
        </ul>
        <a href="#" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
          Get Started
        </a>
      </div>

      <!-- Pro Plan -->
      <div class="bg-gray-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition duration-300">
        <div class="mb-8">
          <h3 class="text-2xl font-semibold text-white">Pro</h3>
          <p class="mt-4 text-gray-400">Ideal for growing businesses and enterprises.</p>
        </div>
        <div class="mb-8">
          <span class="text-5xl font-extrabold text-white">₱99</span>
          <span class="text-xl font-medium text-gray-400">/1 year</span>
        </div>
        <ul class="mb-8 space-y-4 text-gray-400">
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Unlimited user accounts</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Unlimited transactions</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Priority support</span>
          </li>
          <li class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Advanced analytics</span>
          </li>
        </ul>
        <a href="#" class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600">
          Get Started
        </a>
      </div>
    </div>
  </div>
</section>
        <!-- End Blog Article -->
        <!-- Card Blog -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
          <!-- Title -->
          <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">
              Customer stories
            </h2>
            <p class="mt-1 text-gray-600 dark:text-neutral-400">
              See how game-changing companies are making the most of every engagement with
              Preline.
            </p>
          </div>
          <!-- End Title -->

          <!-- Grid -->
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card -->
            <a
              class="group hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 rounded-xl p-5 transition dark:hover:bg-white/10 dark:focus:bg-white/10"
              href="#"
            >
              <div class="aspect-w-16 aspect-h-10">
                <img
                  class="w-full object-cover rounded-xl"
                  src="https://images.unsplash.com/photo-1661956602116-aa6865609028?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80"
                  alt="Blog Image"
                />
              </div>
              <h3
                class="mt-5 text-xl text-gray-800 dark:text-neutral-300 dark:hover:text-white"
              >
                Unity’s inside sales team drives 80% of its revenue with Preline.
              </h3>
              <p
                class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-gray-800 dark:text-neutral-200"
              >
                Learn more
                <svg
                  class="shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="m9 18 6-6-6-6" />
                </svg>
              </p>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a
              class="group hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 rounded-xl p-5 transition dark:hover:bg-white/10 dark:focus:bg-white/10"
              href="#"
            >
              <div class="aspect-w-16 aspect-h-10">
                <img
                  class="w-full object-cover rounded-xl"
                  src="https://images.unsplash.com/photo-1669739432571-aee1f057c41f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80"
                  alt="Blog Image"
                />
              </div>
              <h3
                class="mt-5 text-xl text-gray-800 dark:text-neutral-300 dark:hover:text-white"
              >
                Living Spaces creates a unified experience across the customer journey.
              </h3>
              <p
                class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-gray-800 dark:text-neutral-200"
              >
                Learn more
                <svg
                  class="shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="m9 18 6-6-6-6" />
                </svg>
              </p>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a
              class="group hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 rounded-xl p-5 transition dark:hover:bg-white/10 dark:focus:bg-white/10"
              href="#"
            >
              <div class="aspect-w-16 aspect-h-10">
                <img
                  class="w-full object-cover rounded-xl"
                  src="https://images.unsplash.com/photo-1657299171054-e679f630a776?ixlib=rb-4.0.3&ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80"
                  alt="Blog Image"
                />
              </div>
              <h3
                class="mt-5 text-xl text-gray-800 dark:text-neutral-300 dark:hover:text-white"
              >
                Atlassian powers sales and support at scale with Preline.
              </h3>
              <p
                class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-gray-800 dark:text-neutral-200"
              >
                Learn more
                <svg
                  class="shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path d="m9 18 6-6-6-6" />
                </svg>
              </p>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Grid -->
        </div>

        <!-- Testimonials -->
<div class="overflow-hidden bg-gray-800 dark:bg-gray-900">
  <div class="relative max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Title -->
    <div class="max-w-2xl w-3/4 lg:w-1/2 mb-6 sm:mb-10 md:mb-16">
      <h2 class="text-2xl sm:text-3xl lg:text-4xl text-white font-semibold">
        Loved by business and individuals across the globe
      </h2>
    </div>
    <!-- End Title -->

    <!-- Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Card -->
      <div class="flex h-auto">
        <div class="flex flex-col bg-white rounded-xl dark:bg-neutral-900">
          <div class="flex-auto p-4 md:p-6">
            <p class="text-base italic md:text-lg text-gray-800 dark:text-neutral-200">
              " With Preline, we're able to easily track our performance in full detail. It's become an essential tool for us to grow and engage with our audience. "
            </p>
          </div>

          <div class="p-4 bg-gray-100 rounded-b-xl md:px-7 dark:bg-neutral-800">
            <div class="flex items-center gap-x-3">
              <div class="shrink-0">
                <img class="size-8 sm:size-11.5 rounded-full" src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80" alt="Avatar">
              </div>

              <div class="grow">
                <p class="text-sm sm:text-base font-semibold text-gray-800 dark:text-neutral-200">
                  Josh Tyson
                </p>
                <p class="text-xs text-gray-500 dark:text-neutral-400">
                  Product Manager | Capsule
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="flex h-auto">
        <div class="flex flex-col bg-white rounded-xl dark:bg-neutral-900">
          <div class="flex-auto p-4 md:p-6">
            <p class="text-base italic md:text-lg text-gray-800 dark:text-neutral-200">
              " In September, I will be using this theme for 2 years. I went through multiple updates and changes and I'm very glad to see the consistency and effort made by the team. "
            </p>
          </div>

          <div class="p-4 bg-gray-100 rounded-b-xl md:px-7 dark:bg-neutral-800">
            <div class="flex items-center gap-x-3">
              <div class="shrink-0">
                <img class="size-8 sm:size-11.5 rounded-full" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80" alt="Avatar">
              </div>

              <div class="grow">
                <p class="text-sm sm:text-base font-semibold text-gray-800 dark:text-neutral-200">
                  Luisa
                </p>
                <p class="text-xs text-gray-500 dark:text-neutral-400">
                  Senior Director of Operations | Fitbit
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="flex h-auto">
        <div class="flex flex-col bg-white rounded-xl dark:bg-neutral-900">
          <div class="flex-auto p-4 md:p-6">
            <p class="text-base italic md:text-lg text-gray-800 dark:text-neutral-200">
              " Refreshing and Thought provoking design and it changes my view about how I design the websites. Great typography, modern clean white design, nice tones of the color. "
            </p>
          </div>

          <div class="p-4 bg-gray-100 rounded-b-xl md:px-7 dark:bg-neutral-800">
            <div class="flex items-center gap-x-3">
              <div class="shrink-0">
                <img class="size-8 sm:size-11.5 rounded-full" src="https://images.unsplash.com/photo-1579017331263-ef82f0bbc748?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=900&h=900&q=80" alt="Avatar">
              </div>

              <div class="grow">
                <p class="text-sm sm:text-base font-semibold text-gray-800 dark:text-neutral-200">
                  Alisa Williams
                </p>
                <p class="text-xs text-gray-500 dark:text-neutral-400">
                  Entrepreneur | Happy customer
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Card -->
    </div>
    <!-- End Grid -->

    <!-- Grid -->
    <div class="mt-20 grid gap-6 grid-cols-2 sm:gap-12 lg:grid-cols-3 lg:gap-8">
      <!-- Stats -->
      <div>
        <h4 class="text-lg sm:text-xl font-semibold text-white">Accuracy rate</h4>
        <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-500">99.95%</p>
        <p class="mt-1 text-gray-400">in fulfilling orders</p>
      </div>
      <!-- End Stats -->

      <!-- Stats -->
      <div>
        <h4 class="text-lg sm:text-xl font-semibold text-white">Startup businesses</h4>
        <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-500">2,000+</p>
        <p class="mt-1 text-gray-400">partner with Preline</p>
      </div>
      <!-- End Stats -->

      <!-- Stats -->
      <div>
        <h4 class="text-lg sm:text-xl font-semibold text-white">Happy customer</h4>
        <p class="mt-2 sm:mt-3 text-4xl sm:text-6xl font-bold text-blue-500">85%</p>
        <p class="mt-1 text-gray-400">this year alone</p>
      </div>
      <!-- End Stats -->
    </div>
    <!-- End Grid -->

    <!-- SVG Element -->
    <div class="absolute bottom-0 end-0 transform lg:translate-x-32" aria-hidden="true">
      <svg class="w-40 h-auto sm:w-72" width="1115" height="636" viewBox="0 0 1115 636" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.990203 279.321C-1.11035 287.334 3.68307 295.534 11.6966 297.634L142.285 331.865C150.298 333.965 158.497 329.172 160.598 321.158C162.699 313.145 157.905 304.946 149.892 302.845L33.8132 272.418L64.2403 156.339C66.3409 148.326 61.5475 140.127 53.5339 138.026C45.5204 135.926 37.3213 140.719 35.2207 148.733L0.990203 279.321ZM424.31 252.289C431.581 256.26 440.694 253.585 444.664 246.314C448.635 239.044 445.961 229.931 438.69 225.96L424.31 252.289ZM23.0706 296.074C72.7581 267.025 123.056 230.059 187.043 212.864C249.583 196.057 325.63 198.393 424.31 252.289L438.69 225.96C333.77 168.656 249.817 164.929 179.257 183.892C110.144 202.465 54.2419 243.099 7.92943 270.175L23.0706 296.074Z" fill="currentColor" class="fill-orange-500"/>
        <path d="M451.609 382.417C446.219 388.708 446.95 398.178 453.241 403.567L555.763 491.398C562.054 496.788 571.524 496.057 576.913 489.766C582.303 483.474 581.572 474.005 575.281 468.615L484.15 390.544L562.222 299.413C567.612 293.122 566.881 283.652 560.59 278.263C554.299 272.873 544.829 273.604 539.44 279.895L451.609 382.417ZM837.202 559.655C841.706 566.608 850.994 568.593 857.947 564.09C864.9 559.586 866.885 550.298 862.381 543.345L837.202 559.655ZM464.154 407.131C508.387 403.718 570.802 395.25 638.136 410.928C704.591 426.401 776.318 465.66 837.202 559.655L862.381 543.345C797.144 442.631 718.724 398.89 644.939 381.709C572.033 364.734 504.114 373.958 461.846 377.22L464.154 407.131Z" fill="currentColor" class="fill-cyan-500"/>
        <path d="M447.448 0.194357C439.203 -0.605554 431.87 5.43034 431.07 13.6759L418.035 148.045C417.235 156.291 423.271 163.623 431.516 164.423C439.762 165.223 447.095 159.187 447.895 150.942L459.482 31.5025L578.921 43.0895C587.166 43.8894 594.499 37.8535 595.299 29.6079C596.099 21.3624 590.063 14.0296 581.818 13.2297L447.448 0.194357ZM1086.03 431.727C1089.68 439.166 1098.66 442.239 1106.1 438.593C1113.54 434.946 1116.62 425.96 1112.97 418.521L1086.03 431.727ZM434.419 24.6572C449.463 42.934 474.586 81.0463 521.375 116.908C568.556 153.07 637.546 187.063 742.018 200.993L745.982 171.256C646.454 157.985 582.444 125.917 539.625 93.0974C496.414 59.978 474.537 26.1903 457.581 5.59138L434.419 24.6572ZM742.018 200.993C939.862 227.372 1054.15 366.703 1086.03 431.727L1112.97 418.521C1077.85 346.879 956.138 199.277 745.982 171.256L742.018 200.993Z" fill="currentColor" class="fill-white"/>
      </svg>
    </div>
    <!-- End SVG Element -->
  </div>
</div>
<!-- End Testimonials -->
        <!-- Contact Us -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
          <div class="max-w-2xl lg:max-w-5xl mx-auto">
            <div class="text-center">
              <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
                Contact us
              </h1>
              <p class="mt-1 text-gray-600 dark:text-neutral-400">
                We'd love to talk about how we can help you.
              </p>
            </div>

            <div class="mt-12 grid items-center lg:grid-cols-2 gap-6 lg:gap-16">
              <!-- Card -->
              <div
                class="flex flex-col border border-gray-200 rounded-xl p-4 sm:p-6 lg:p-8 dark:border-neutral-700"
              >
                <h2
                  class="mb-8 text-xl font-semibold text-gray-800 dark:text-neutral-200"
                >
                  Fill in the form
                </h2>

                <form>
                  <div class="grid gap-4">
                    <!-- Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div>
                        <label for="hs-firstname-contacts-1" class="sr-only"
                          >First Name</label
                        >
                        <input
                          type="text"
                          name="hs-firstname-contacts-1"
                          id="hs-firstname-contacts-1"
                          class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:border-blue-800 dark:text-black-800 dark:placeholder-neutral-500 dark:focus:ring-blue-800"
                          placeholder="First Name"
                          
                        />
                      </div>

                      <div>
                        <label for="hs-lastname-contacts-1" class="sr-only"
                          >Last Name</label
                        >
                        <input
                          type="text"
                          name="hs-lastname-contacts-1"
                          id="hs-lastname-contacts-1"
                                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:border-blue-800 dark:text-black-800 dark:placeholder-neutral-500 dark:focus:ring-blue-800"
                                   placeholder="Last Name"
                                />
                      </div>
                    </div>
                    <!-- End Grid -->

                    <div>
                      <label for="hs-email-contacts-1" class="sr-only">Email</label>
                      <input
                        type="email"
                        name="hs-email-contacts-1"
                        id="hs-email-contacts-1"
                        autocomplete="email"
                        :value="user?.email || ''"
                       class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:border-blue-800 dark:text-black-800 dark:placeholder-neutral-500 dark:focus:ring-blue-800"
                              placeholder="Email"
                       />
                    </div>

                    <div>
                      <label for="hs-phone-number-1" class="sr-only">Phone Number</label>
                      <input
                        type="text"
                        name="hs-phone-number-1"
                        id="hs-phone-number-1"
                        class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:border-blue-800 dark:text-black-800 dark:placeholder-neutral-500 dark:focus:ring-blue-800"
                              placeholder="Phone Number"
                        />
                    </div>

                    <div>
                      <label for="hs-about-contacts-1" class="sr-only">Details</label>
                      <textarea
                        id="hs-about-contacts-1"
                        name="hs-about-contacts-1"
                        rows="4"
                               placeholder="Describe your inquiry"
                        class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:border-blue-800 dark:text-black-800 dark:placeholder-neutral-500 dark:focus:ring-blue-800"
                         ></textarea>
                    </div>
                  </div>
                  <!-- End Grid -->

                  <div class="mt-4 grid">
                    <button
                      type="submit"
                      class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                    >
                      Send inquiry
                    </button>
                  </div>

                  <div class="mt-3 text-center">
                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                      We'll get back to you in 1-2 business days.
                    </p>
                  </div>
                </form>
              </div>
              <!-- End Card -->

              <div class="divide-y divide-gray-200 dark:divide-neutral-800">
                <!-- Icon Block -->
                <div class="flex gap-x-7 py-6">
                  <svg
                    class="shrink-0 size-6 mt-1.5 text-gray-800 dark:text-neutral-200"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                    <path d="M12 17h.01" />
                  </svg>
                  <div class="grow">
                    <h3 class="font-semibold text-gray-800 dark:text-neutral-200">
                      Knowledgebase
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
                      We're here to help with any questions or code.
                    </p>
                    <a
                      class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                      href="#"
                    >
                      Contact support
                      <svg
                        class="shrink-0 size-2.5 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.975821 6.92249C0.43689 6.92249 -3.50468e-07 7.34222 -3.27835e-07 7.85999C-3.05203e-07 8.37775 0.43689 8.79749 0.975821 8.79749L12.7694 8.79748L7.60447 13.7596C7.22339 14.1257 7.22339 14.7193 7.60447 15.0854C7.98555 15.4515 8.60341 15.4515 8.98449 15.0854L15.6427 8.68862C16.1191 8.23098 16.1191 7.48899 15.6427 7.03134L8.98449 0.634573C8.60341 0.268455 7.98555 0.268456 7.60447 0.634573C7.22339 1.00069 7.22339 1.59428 7.60447 1.9604L12.7694 6.92248L0.975821 6.92249Z"
                          fill="currentColor"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- End Icon Block -->

                <!-- Icon Block -->
                <div class="flex gap-x-7 py-6">
                  <svg
                    class="shrink-0 size-6 mt-1.5 text-gray-800 dark:text-neutral-200"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path
                      d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"
                    />
                    <path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1" />
                  </svg>
                  <div class="grow">
                    <h3 class="font-semibold text-gray-800 dark:text-neutral-200">FAQ</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
                      Search our FAQ for answers to anything you might ask.
                    </p>
                    <a
                      class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                      href="#"
                    >
                      Visit FAQ
                      <svg
                        class="shrink-0 size-2.5 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.975821 6.92249C0.43689 6.92249 -3.50468e-07 7.34222 -3.27835e-07 7.85999C-3.05203e-07 8.37775 0.43689 8.79749 0.975821 8.79749L12.7694 8.79748L7.60447 13.7596C7.22339 14.1257 7.22339 14.7193 7.60447 15.0854C7.98555 15.4515 8.60341 15.4515 8.98449 15.0854L15.6427 8.68862C16.1191 8.23098 16.1191 7.48899 15.6427 7.03134L8.98449 0.634573C8.60341 0.268455 7.98555 0.268456 7.60447 0.634573C7.22339 1.00069 7.22339 1.59428 7.60447 1.9604L12.7694 6.92248L0.975821 6.92249Z"
                          fill="currentColor"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- End Icon Block -->

                <!-- Icon Block -->
                <div class="flex gap-x-7 py-6">
                  <svg
                    class="shrink-0 size-6 mt-1.5 text-gray-800 dark:text-neutral-200"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="m7 11 2-2-2-2" />
                    <path d="M11 13h4" />
                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                  </svg>
                  <div class="grow">
                    <h3 class="font-semibold text-gray-800 dark:text-neutral-200">
                      Developer APIs
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
                      Check out our development quickstart guide.
                    </p>
                    <a
                      class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                      href="#"
                    >
                      Contact sales
                      <svg
                        class="shrink-0 size-2.5 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.975821 6.92249C0.43689 6.92249 -3.50468e-07 7.34222 -3.27835e-07 7.85999C-3.05203e-07 8.37775 0.43689 8.79749 0.975821 8.79749L12.7694 8.79748L7.60447 13.7596C7.22339 14.1257 7.22339 14.7193 7.60447 15.0854C7.98555 15.4515 8.60341 15.4515 8.98449 15.0854L15.6427 8.68862C16.1191 8.23098 16.1191 7.48899 15.6427 7.03134L8.98449 0.634573C8.60341 0.268455 7.98555 0.268456 7.60447 0.634573C7.22339 1.00069 7.22339 1.59428 7.60447 1.9604L12.7694 6.92248L0.975821 6.92249Z"
                          fill="currentColor"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- End Icon Block -->

                <!-- Icon Block -->
                <div class="flex gap-x-7 py-6">
                  <svg
                    class="shrink-0 size-6 mt-1.5 text-gray-800 dark:text-neutral-200"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path
                      d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z"
                    />
                    <path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10" />
                  </svg>
                  <div class="grow">
                    <h3 class="font-semibold text-gray-800 dark:text-neutral-200">
                      Contact us by email
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
                      If you wish to write us an email instead please use
                    </p>
                    <a
                      class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                      href="#"
                    >
                      example@site.com
                    </a>
                  </div>
                </div>
                <!-- End Icon Block -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ========== FOOTER ========== -->

      <!-- ========== END FOOTER ========== -->
 <div
    v-if="showCookies"
    id="cookies-simple-with-dismiss-button"
    class="fixed bottom-0 start-1/2 transform -translate-x-1/2 z-60 sm:max-w-4xl w-full mx-auto p-6"
  >
    <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-800">
      <div class="flex justify-between items-center gap-x-5 sm:gap-x-10">
        <div class="grow">
          <h2 class="text-sm text-gray-600 dark:text-neutral-400">
            By continuing to use this site you consent to the use of cookies in accordance with our
            <a
              class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500"
              href="#"
              >Cookies Policy.</a
            >
          </h2>
        </div>
        <button
          @click="dismissCookies"
          type="button"
          class="p-2 cursor-pointer inline-flex items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:bg-white/10 dark:text-white dark:hover:bg-white/20 dark:focus:bg-white/20"
        >
          <span class="sr-only">Dismiss</span>
          <svg
            class="shrink-0 size-5"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
    </WelcomeLayout>
    <template #fallback>
      <PlaceholderPattern />
    </template>
  </Suspense>
</template>
