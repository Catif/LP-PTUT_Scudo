<template>
  <nav>
    <router-link to="/">Home</router-link>
    <router-link to="/test">Test</router-link>
  </nav>
</template>

<style lang="scss">
nav {
  display: flex;
  gap: 10px;
  padding: 1rem;
  background-color: rgba(255, 255, 255, 0.144);
  color: #fff;
  a {
    color: rgb(0, 255, 213);
    text-decoration: none;
    &:hover {
      text-decoration: underline;
    }
  }
}
</style>
