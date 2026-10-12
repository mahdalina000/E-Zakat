# Kontrak API E-Zakat

File kontrak ada di **`openapi.yaml`** (OpenAPI 3.0.3) di root repository ini.
Ini adalah **Single Source of Truth** — semua perubahan API harus lewat PR yang mengubah file ini dulu (Design-First).

## Cara Kerja (GitHub sebagai Kontrak)

1. **Buat branch baru** untuk perubahan API:
   ```bash
   git checkout -b feat/kontrak-lokasi
   ```
2. **Edit `openapi.yaml`** (pakai VS Code + extension `42Crunch.vscode-openapi` atau https://editor.swagger.io)
3. **Validasi lokal sebelum push:**
   ```bash
   npx @redocly/cli lint openapi.yaml
   npx @apidevtools/swagger-cli validate openapi.yaml
   ```
4. **Push & buat Pull Request** ke `main`:
   ```bash
   git add openapi.yaml
   git commit -m "feat(api): tambah endpoint locations filter"
   git push -u origin feat/kontrak-lokasi
   ```
   Workflow `Validate API Contract` akan otomatis mengecek validitas OpenAPI. Jika gagal, PR tidak bisa di-merge.
5. **Review & Merge** → setelah merge, buat tag versi:
   ```bash
   git tag v1.1.0
   git push origin v1.1.0
   ```
   Ikuti SemVer: `MAJOR` untuk breaking change, `MINOR` untuk endpoint baru, `PATCH` untuk fix deskripsi/example.

## Menjalankan Mock Server (Frontend bisa coding tanpa backend)

```bash
# install prism sekali
npm install -g @stoplight/prism-cli

# jalankan mock
npx prism mock openapi.yaml --port 4010

# CATATAN: Prism memakai path dari spec, BUKAN prefix servers (/api).
# Jadi panggil tanpa /api:
curl http://localhost:4010/beras-price
curl -X POST http://localhost:4010/kalkulator/zakat-fitrah -H "Content-Type: application/json" -d '{"jumlah_jiwa":4}'
curl 'http://localhost:4010/locations?type=upz&per_page=2'
```

> **Sudah diuji jalan:** `GET /beras-price` → 200 + data contoh, `POST /kalkulator/zakat-fitrah` → hitungan sesuai (4 jiwa = 10 kg / Rp160.000), `PUT /beras-price` tanpa token → `401 Unauthenticated` (sesuai skema `bearerAuth`).

## Generate Dokumentasi Lokal

```bash
npx @redocly/cli preview-docs openapi.yaml
# atau build statis
npx @redocly/cli build-docs openapi.yaml -o docs/index.html
```

Dokumentasi otomatis ter-deploy ke **GitHub Pages** setiap push ke `main` (workflow `Deploy API Docs`).

## Generate Code / Contract Testing

- **Laravel:** test kesesuaian implementasi dengan `schemathesis` atau `spectator` (https://github.com/hotmeteor/spectator)
- **Generate client:** `npx @openapitools/openapi-generator-cli generate -i openapi.yaml -g typescript-axios -o ./frontend/src/api`

## Aturan Kontrak

- Jangan ubah field tanpa bump versi MINOR/MAJOR.
- Field baru harus optional / nullable agar tidak breaking.
- Semua response error wajib pakai schema `ErrorResponse`.
- Pagination wajib pakai `PaginatedResponse`.

## Protection (Disarankan)

Aktifkan di GitHub → Settings → Branches → Add rule untuk `main`:
- Require pull request reviews
- Require status checks: `validate`
