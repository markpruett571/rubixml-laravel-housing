import { defineConfig, presetWind, presetWebFonts, presetTypography } from 'unocss';

export default defineConfig({
    presets: [
        presetWind(),
        presetTypography(),
        presetWebFonts({
            provider: "google",
            fonts: {
                sans: "Roboto"
            }
        })
    ]
})
