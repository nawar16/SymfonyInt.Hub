<template>
  <nav class="main-nav">
    <router-link to="/" class="nav-link">Products</router-link>
    <router-link to="/logs" class="nav-link">Sync Logs</router-link>
  </nav>

  <main>
    <router-view /> 
  </main>
</template>

<style scoped>
.main-nav {
  display: flex;
  gap: 2rem;
  justify-content: center;
  padding: 1.5rem;
  background: white;
  border-bottom: 1px solid #e2e8f0;
}
.nav-link {
  text-decoration: none;
  color: #64748b;
  font-weight: 600;
}
.router-link-active {
  color: #2563eb; 
}
</style>
