# Design System & UI Guidelines (Red Edition)

## 1. Tipografi (Fonts)
Menggunakan Google Fonts yang di-load pada layout utama `resources/views/layouts/app.blade.php`:
- **Heading / Judul:** `Montserrat` (Bold 700, SemiBold 600) — Modern, tegas, dan berbobot.
- **Body / Teks Utama:** `Poppins` (Regular 400, Medium 500) — Keterbacaan optimal untuk dashboard, formulir, dan data tabel.

## 2. Palet Warna (Color Palette)

### Background Colors
- **Primary Background:** `#FAFAFB` (Clean neutral white dengan tone abu ultra-ringan yang nyaman di mata)
- **Secondary Background:** `#FFFFFF` (Pure White dengan border lembut `#E5E7EB` / `#F3F4F6` dan shadow halus)

### Brand & Accent Colors (Red Edition)
- **Primary Gradient / Accent:** Linear Gradient dari `#DC2626` (Red 600) ke `#E11D48` (Rose 600) & `#B91C1C` (Red 700) — digunakan untuk tombol aksi utama (CTA), logo, *active state* navigasi, dan *badge* poin.
- **Brand Glow & Shadows:** `rgba(220, 38, 38, 0.25)` untuk elevasi modern pada tombol dan kartu utama.
- **Secondary Accent:** `#1F2937` (Slate 800) / `#111827` (Gray 900) untuk teks utama dan dark hero card.

### Semantic Colors (Status)
- **Success (Grade A / Disetujui):** `#10B981` (Emerald 500)
- **Info (Grade B):** `#3B82F6` (Blue 500)
- **Warning (Grade C / Pending):** `#F59E0B` (Amber 500)
- **Danger (Grade D / Ditolak):** `#EF4444` (Red 500)
