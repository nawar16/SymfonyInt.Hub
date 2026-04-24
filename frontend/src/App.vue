<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios, { AxiosError } from 'axios'

interface Product {
  id: number
  name: string
  price: number
  status?: string 
}

const products = ref<Product[]>([])
const loading = ref<boolean>(true)
const error = ref<string | null>(null)

onMounted(async () => {
  try {
    const res = await axios.get<Product[]>('http://localhost:8000/api/products')
    products.value = Array.isArray(res.data) ? res.data : (res.data as any)['hydra:member'] || []
  } catch (err) {
    error.value = "Backend unreachable. Check CORS or Server."
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="page-wrapper">
    <div class="glass-card">
      <div class="card-header">
        <div>
          <h2>Products</h2>
        </div>
      </div>
      <div class="table-container">
        <table class="modern-table">
          <thead>
            <tr>
              <th>Product Details</th>
              <th>Status</th>
              <th class="text-right">Price</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading" v-for="n in 3" :key="n" class="skeleton-row">
              <td colspan="3"><div class="skeleton-bar"></div></td>
            </tr>
            
            <tr v-for="p in products" :key="p.id">
              <td>
                <div class="product-info">
                  <div class="avatar">{{ p.name.charAt(0) }}</div>
                  <div>
                    <div class="main-text">{{ p.name }}</div>
                    <div class="sub-text">ID: {{ p.id }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge">In Stock</span>
              </td>
              <td class="text-right price-tag">
                {{ p.price.toLocaleString('de-DE', { minimumFractionDigits: 2 }) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div v-if="!loading && products.length === 0" class="empty-state">
        No products found in the database.
      </div>
    </div>
  </div>
</template>

<style scoped>

.page-wrapper {
  background: #f8fafc;
  min-height: 100vh;
  padding: 4rem 1rem;
  font-family: 'Inter', -apple-system, sans-serif;
}

.glass-card {
  background: white;
  max-width: 900px;
  margin: 0 auto;
  border-radius: 16px;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  overflow: hidden;
}

.card-header {
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #f1f5f9;
}

.card-header h2 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
  color: #1e293b;
}

.card-header p {
  margin: 0;
  font-size: 0.875rem;
  color: #64748b;
}

.add-btn {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}

.add-btn:hover { background: #1d4ed8; }

.table-container { overflow-x: auto; }

.modern-table {
  width: 100%;
  border-collapse: collapse;
}

.modern-table th {
  background: #f8fafc;
  padding: 0.75rem 2rem;
  text-align: left;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #64748b;
}

.modern-table td {
  padding: 1.25rem 2rem;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}

.product-info { display: flex; align-items: center; gap: 1rem; }

.avatar {
  width: 40px;
  height: 40px;
  background: #eff6ff;
  color: #3b82f6;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

.main-text { font-weight: 600; color: #1e293b; }
.sub-text { font-size: 0.75rem; color: #94a3b8; }

.badge {
  background: #f0fdf4;
  color: #166534;
  padding: 0.25rem 0.75rem;
  border-radius: 99px;
  font-size: 0.75rem;
  font-weight: 600;
}

.price-tag {
  font-family: 'JetBrains Mono', monospace;
  font-weight: 700;
  color: #0f172a;
}

.text-right { text-align: right; }

.skeleton-bar {
  height: 20px;
  background: #f1f5f9;
  border-radius: 4px;
  width: 100%;
  animation: pulse 1.5s infinite;
}

@keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0.4; }
  100% { opacity: 1; }
}

.empty-state {
  padding: 4rem;
  text-align: center;
  color: #94a3b8;
}

.modern-table th, 
.modern-table td {
  text-align: center !important;
}

.product-info.justify-center {
  justify-content: center;
}

.card-header {
  text-align: center;
  justify-content: center;
}
</style>
