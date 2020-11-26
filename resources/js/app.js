require('alpinejs')

const pad = number => number < 10 ? '0' + number : number

// Get route for today's note according to local time zone
const now = new Date()
window.TODAY_ISO = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())}`
window.TODAY_ROUTE = window.NOTE_EDIT_ROUTE.replace(
    '__replace__',
    window.TODAY_ISO
)
