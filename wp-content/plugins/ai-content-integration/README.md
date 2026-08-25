# WeekMate City Page Generator — WordPress Plugin

Auto-detects visitor IP → resolves city/state → calls Groq LLM → creates a
fully-hydrated city-specific landing page → redirects visitor to it.
Each city is generated **once** and cached. Repeat visitors from the same city
hit zero API calls — they get a 301 redirect in milliseconds.

---

## Folder Structure

```
weekmate-city-pages/
├── weekmate-city-pages.php   ← main plugin file
├── template/
│   └── city-page.html        ← copy your HTML template here (optional but recommended)
└── README.md
```

---

## Installation

1. Copy the `weekmate-city-pages/` folder into `/wp-content/plugins/`.
2. Go to **Plugins → Installed Plugins** and activate **WeekMate City Page Generator**.
3. Go to **Settings → WeekMate City Pages** and fill in:
   - **Groq API Key** — get one free at https://console.groq.com
   - **Groq Model** — default: `llama-3.3-70b-versatile`
   - **Post Status** — `publish` to go live immediately, `draft` to review first
   - **Base Blog Path** — e.g. `blog` → produces `/blog/payroll-software-in-surat/`
4. *(Optional)* Copy your HTML template file into `template/city-page.html`.
   If absent, the plugin generates clean semantic HTML that works with any theme.

---

## How It Works (end-to-end flow)

```
Visitor hits /blog/hr-payroll-software/
        │
        ▼
Plugin fires on template_redirect
        │
        ▼
wmcp_get_visitor_ip()   ← Cloudflare / X-Forwarded-For / REMOTE_ADDR
        │
        ▼
wmcp_resolve_location() ← ipapi.co (primary) → ip-api.com (fallback)
        │                  Result cached in WP transients for 6 hours
        ▼
City key = sanitize(city-state)
        │
        ├─── City in DB cache? ──YES──▶ 301 redirect to existing post
        │
        NO
        │
        ▼
wmcp_call_groq()        ← sends master prompt to Groq API
        │                  Model: llama-3.3-70b-versatile
        │                  temp=0.7, max_tokens=4096
        │                  Response stripped of markdown fences
        │                  JSON validated + fallback regex extraction
        ▼
wmcp_create_wp_post()   ← creates WP post with:
        │                  - post_name = url_slug from JSON
        │                  - post_content = hydrated HTML template
        │                  - Yoast + RankMath SEO meta populated
        │                  - FAQPage JSON-LD injected
        │                  - Custom category assigned
        ▼
wmcp_save_cache()       ← stores in wp_wmcp_city_cache table
        │
        ▼
301 redirect → /blog/payroll-software-in-{city}/
```

---

## Trigger Post

The plugin listens for your existing post at:
```
http://localhost/weekmate/blog/hr-payroll-software/
```

The slug `hr-payroll-software` is set as `WMCP_TRIGGER_POST` constant at the
top of the plugin. Change it to match your actual post slug.

---

## Permalink Setup

**Recommended WordPress permalink structure:**
```
Settings → Permalinks → Custom Structure: /%category%/%postname%/
```

This gives you clean URLs like:
```
/blog/payroll-software-in-ahmedabad/
/blog/payroll-software-in-pune/
/blog/payroll-software-in-chennai/
```

---

## Manual Generation via REST API

Useful for pre-generating pages for known cities, or testing via Postman:

```
POST /wp-json/wmcp/v1/generate
Authorization: Basic <admin:password>
Content-Type: application/json

{
  "city": "Surat",
  "state": "Gujarat"
}
```

Response:
```json
{
  "source": "groq",
  "post_id": 142,
  "post_url": "http://localhost/weekmate/blog/payroll-software-in-surat/",
  "slug": "payroll-software-in-surat",
  "meta_title": "Payroll Software in Surat | WeekMate HRMS"
}
```

---

## Dashboard Widget

Go to **Dashboard → Home** — a "WeekMate City Pages — Stats" widget shows:
- Total cities generated
- Last 20 entries with city, state, generated date, View & Edit links

---

## Cache Management

**Settings → WeekMate City Pages → Flush All City Cache**

This truncates the `wp_wmcp_city_cache` table. The next visitor from each city
will trigger a fresh Groq API call and a new WordPress post.

> **Note:** Flushing the cache does NOT delete the existing WordPress posts.
> Those remain live. The next trigger hit will simply create a new post with
> refreshed AI content.

---

## IP Geolocation

| Provider | Limit | Key Required |
|---|---|---|
| ipapi.co | 30,000 req/month free | No |
| ip-api.com | Unlimited (fair use) | No |

Location results are cached in WP transients for **6 hours** per IP.

---

## SEO Meta Compatibility

The plugin writes to both **Yoast SEO** and **Rank Math** meta fields
automatically. If you use a different SEO plugin, add its meta key to
`wmcp_create_wp_post()` in the same pattern.

---

## Groq Prompt Architecture (15-year senior-level)

The master prompt (`wmcp_build_prompt()`) enforces:

| Rule | Detail |
|---|---|
| City grounding | Named industries, economic zones, SEZs, workforce patterns |
| Compliance distribution | 15 Indian HR/payroll terms spread across sections |
| SEO precision | Primary keyword placement, 60-char title, 145–155 char description |
| Places | Business-context descriptions, not tourist copy |
| Pain/Solution 1:1 | Solutions bullet order maps directly to pain points |
| FAQ intent | Real search queries a business owner would type |
| Output contract | System prompt + user prompt both enforce JSON-only output |
| Fence stripping | Regex strips accidental markdown code fences from response |
| JSON repair | Fallback regex extracts `{...}` if outer wrapper text slips through |

---

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Groq API key (free at console.groq.com)
- Outbound HTTP access from your server (wp_remote_get/post)
- Permalink structure set to anything except "Plain"
