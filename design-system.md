# SPA Armonía — Design System & Figma Specifications

Este documento define los tokens, componentes y pantallas para importar en Figma.

---

## 1. Design Tokens (Semánticos)

> **Nota:** Los colores hex listados abajo corresponden a las utilidades `emerald` de Tailwind CSS.
> NO están confirmados con el cliente. En Figma, crear estos tokens como variables y reemplazar cuando se confirmen los colores definitivos.

### Color Palette

| Token | Uso | Tailwind Class | Hex (no confirmado) |
|-------|-----|----------------|---------------------|
| `bg-primary` | Botones, acentos principales | `bg-emerald-600` | `#059669` |
| `bg-primary-hover` | Hover de botones | `bg-emerald-700` | `#047857` |
| `bg-primary-light` | Badges, backgrounds suaves | `bg-emerald-100` | `#d1fae5` |
| `bg-surface` | Fondo principal | `bg-slate-50` | `#f8fafc` |
| `bg-surface-dark` | Fondo dark mode | `bg-slate-900` | `#0f172a` |
| `bg-card` | Cards, paneles | `bg-white` | `#ffffff` |
| `bg-card-dark` | Cards dark mode | `bg-slate-800` | `#1e293b` |
| `text-primary` | Texto principal | `text-gray-900` | `#111827` |
| `text-muted` | Texto secundario | `text-gray-500` | `#6b7280` |
| `text-primary-dark` | Texto principal dark | `text-gray-100` | `#f3f4f6` |
| `accent` | Links, acciones | `text-emerald-600` | `#059669` |
| `success` | Estado confirmado | `bg-emerald-100` | `#d1fae5` |
| `danger` | Estado cancelado, errores | `bg-red-100` | `#fee2e2` |
| `warning` | Estado pendiente | `bg-amber-100` | `#fef3c7` |
| `info` | Estado finalizado | `bg-blue-100` | `#dbeafe` |

### Typography

| Token | Font | Weight | Size | Uso |
|-------|------|--------|------|-----|
| `heading-1` | Inter | Bold (700) | 36px / 2.25rem | Títulos de página |
| `heading-2` | Inter | Bold (700) | 30px / 1.875rem | Secciones |
| `heading-3` | Inter | SemiBold (600) | 20px / 1.25rem | Sub-secciones |
| `body` | Inter | Regular (400) | 16px / 1rem | Texto general |
| `body-small` | Inter | Regular (400) | 14px / 0.875rem | Texto secundario |
| `caption` | Inter | Medium (500) | 12px / 0.75rem | Labels, badges |

> **Nota:** La familia tipográfica exacta NO está confirmada. Se usa Inter como default.

### Spacing

- **Unidad base:** 8px
- **Escala:** 4, 8, 12, 16, 20, 24, 32, 40, 48, 64, 80, 96px
- **Padding cards:** 24px
- **Padding botones:** 10px vertical, 20px horizontal
- **Gap entre elementos:** 16px (default), 24px (grupos)

### Grid

| Breakpoint | Columnas | Ancho máximo | Padding |
|------------|----------|--------------|---------|
| Mobile (< 640px) | 1 | 100% | 16px |
| Tablet (640-1024px) | 4 | 100% | 24px |
| Desktop (> 1024px) | 12 | 1280px | 32px |

### Border Radius

| Token | Valor | Uso |
|-------|-------|-----|
| `radius-sm` | 8px | Inputs, badges |
| `radius-md` | 12px | Cards, botones |
| `radius-lg` | 16px | Modales, avatares grandes |
| `radius-xl` | 24px | Hero sections |
| `radius-full` | 999px | Avatares circulares, pills |

### Shadows

| Token | Valor | Uso |
|-------|-------|-----|
| `shadow-sm` | `0 1px 2px rgba(0,0,0,0.05)` | Cards default |
| `shadow-md` | `0 4px 6px rgba(0,0,0,0.07)` | Cards hover |
| `shadow-lg` | `0 10px 15px rgba(0,0,0,0.1)` | Modales, dropdowns |

---

## 2. Components (Atómicos)

### Buttons

| Variante | Estado | Fondo | Texto | Border |
|----------|--------|-------|-------|--------|
| Primary | Default | `bg-primary` | White | None |
| Primary | Hover | `bg-primary-hover` | White | None |
| Primary | Disabled | `bg-primary` opacity 50% | White | None |
| Secondary | Default | White | `text-gray-700` | `border-gray-300` |
| Secondary | Hover | `bg-gray-50` | `text-gray-900` | `border-gray-300` |
| Danger | Default | `bg-red-600` | White | None |
| Danger | Hover | `bg-red-700` | White | None |

**Sizes:** `sm` (px-3 py-1.5), `md` (px-5 py-2.5), `lg` (px-8 py-4)

### Input Fields

- Border: 1px `border-gray-300`
- Border radius: 8px
- Padding: 10px 16px
- Focus: 2px ring `primary/20`, border `primary`
- Error: border `red-500`, ring `red-500/20`

### Badges de Estado

| Estado | Background | Text Color |
|--------|-----------|------------|
| Pendiente | `amber-100` | `amber-800` |
| Confirmada | `emerald-100` | `emerald-800` |
| Cancelada | `red-100` | `red-800` |
| Finalizada | `blue-100` | `blue-800` |

### Cards

- Background: white (dark: `slate-800`)
- Border: 1px `gray-100` (dark: `slate-700`)
- Border radius: 12px
- Shadow: `shadow-sm`
- Hover variant: `shadow-md` + `translateY(-2px)`

### Modal

- Backdrop: black 50% + blur-sm
- Container: white, `radius-lg`, `shadow-lg`
- Header: border-bottom separator
- Animation: scale 95% → 100% + fade

### Avatar

- Círculo con iniciales del nombre
- Background: `primary-100` (dark: `primary-900/30`)
- Texto: `primary-700` (dark: `primary-400`)
- Sizes: 40px (sm), 48px (md), 80px (lg)

---

## 3. Pantallas (Frames en Figma)

### 3.1 Landing Page (`/`)
- **Header:** Navbar con logo + nav links + CTA "Reservar"
- **Hero:** Gradiente primario, título grande, subtítulo, 2 CTAs
- **Stats:** 4 métricas (Clientes, Tratamientos, Especialistas, Rating)
- **Servicios:** Grid 3 columnas de service-cards
- **CTA Final:** Banner gradiente con botón "Reservar Ahora"
- **Footer:** 3 columnas (brand, links, contacto)

### 3.2 Página Servicios (`/servicios`)
- Barra de búsqueda
- Grid de service-cards (responsive: 1/2/3 columnas)

### 3.3 Formulario de Reserva (`/citas`)
- Selección de servicios con checkboxes
- Select de masajista
- Date + time pickers
- Textarea notas
- Botón submit con loading state

### 3.4 Login Admin (`/login`)
- Card centrada con logo
- Input usuario + contraseña (con toggle visibility)
- Botón "Ingresar"

### 3.5 Dashboard Admin (`/dashboard`)
- Navbar admin con links + "Nueva Cita"
- Grid de 4 stat-cards
- Panel "Acciones Rápidas" (sidebar-like)
- Lista "Citas Recientes" con avatares y badges

### 3.6 Historial de Citas (`/dashboard/citas`)
- Header con título + botón "Nueva Cita"
- Barra de filtros (búsqueda, estado, fecha desde/hasta)
- Lista de cita-cards con: avatar, info cliente, fecha/hora, masajista, habitación, service-tags, badge de estado, total, menú de acciones (3 dots)
- Nota destacada en fondo amber si existe

### 3.7 Nueva Cita (`/dashboard/citas/create`)
- Banner header con gradiente
- Sección "Información del Cliente" con toggle Existente/Nuevo
- Sección "Detalles de la Cita" (masajista, habitación, fecha, hora, estado, notas)
- Sección "Servicios" con select dinámico, lista agregada con duración editable, total

### 3.8 Gestión de Masajistas (`/dashboard/masajistas`)
- Grid de cards de masajista con: avatar, nombre, cédula, teléfono, stats (citas/finalizadas/comisión), tags de servicios
- Modal para crear nuevo masajista

### 3.9 Ficha de Masajista (`/dashboard/masajistas/{id}`)
- Card de perfil con avatar grande
- Tabla de servicios y comisiones
- Historial de citas

### 3.10 Gestión de Clientes (`/dashboard/clientes`)
- Tabla con columnas: cédula, nombre, teléfono, correo, # citas, acciones
- Modal para crear nuevo cliente

### 3.11 Ficha de Cliente (`/dashboard/clientes/{id}`)
- Card de perfil con historial de citas

### 3.12 Gestión de Servicios (`/dashboard/servicios`)
- Tabla con columnas: ID, nombre, precio, descripción, acciones
- Modal para crear nuevo servicio

---

## 4. Microinteracciones

| Interacción | Trigger | Animación |
|-------------|---------|-----------|
| Card hover | Mouse enter | `translateY(-2px)` + shadow increase, 200ms ease |
| Button hover | Mouse enter | Background darken + shadow, 200ms |
| Modal open | Click trigger | Backdrop fade-in + card scale 95→100%, 300ms ease-out |
| Modal close | Click outside/ESC | Reverse, 200ms ease-in |
| Dropdown menu | Click toggle | Fade + slide-down, 200ms |
| Flash notification | Auto | Slide-down from top, auto-dismiss at 4s with fade-out |
| Badge | Static | No animation (consider pulse for "pendiente") |
| Focus ring | Tab/Click input | 2px ring with primary color at 20% opacity |
| Loading spinner | Submit button | Rotate 360° infinite, opacity swap on text |
| Dark mode toggle | Click | Instant class toggle on `<html>` |

---

## 5. Dark Mode

Todas las pantallas deben tener variante dark mode:
- Toggle via clase `.dark` en `<html>`
- Backgrounds: `slate-900`, `slate-800`, `slate-700`
- Textos: `gray-100`, `gray-300`, `gray-400`
- Borders: `slate-700`
- Badges: opacity reducida con tono oscuro

---

## 6. Accesibilidad

- Todos los inputs tiene `<label for="">` asociado
- Roles ARIA en tablas y formularios
- Contraste mínimo 4.5:1 para texto
- Focus visible en todos los elementos interactivos
- Mobile-first responsive design
