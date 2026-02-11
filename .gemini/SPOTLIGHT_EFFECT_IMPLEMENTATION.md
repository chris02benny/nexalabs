# Spotlight Card Effect Implementation

## Overview
Successfully converted the React SpotlightCard component to vanilla HTML/CSS/JavaScript and integrated it into the NEXA Future Ready Lab website.

## What Was Implemented

### ✨ Interactive Spotlight Effect
A beautiful, interactive spotlight effect that follows the user's mouse cursor as they hover over program cards and learner group cards.

## Technical Implementation

### 1. **CSS (style.css)**

#### Program Detail Cards
```css
.program-detail-card {
  position: relative;
  overflow: hidden;
  --mouse-x: 50%;
  --mouse-y: 50%;
  --spotlight-color: rgba(138, 99, 210, 0.15);
}

.program-detail-card::before {
  content: '';
  position: absolute;
  background: radial-gradient(
    circle 400px at var(--mouse-x) var(--mouse-y),
    var(--spotlight-color),
    transparent 80%
  );
  opacity: 0;
  transition: opacity 0.5s ease;
}

.program-detail-card:hover::before {
  opacity: 1;
}
```

#### Learner Group Cards
```css
.learner-group-card {
  position: relative;
  overflow: hidden;
  --mouse-x: 50%;
  --mouse-y: 50%;
  --spotlight-color: rgba(138, 99, 210, 0.12);
}

.learner-group-card::before {
  background: radial-gradient(
    circle 350px at var(--mouse-x) var(--mouse-y),
    var(--spotlight-color),
    transparent 80%
  );
}
```

### 2. **JavaScript (main.js)**

```javascript
function initSpotlightCards() {
    const spotlightCards = document.querySelectorAll('.program-detail-card, .learner-group-card');
    
    spotlightCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
        
        card.addEventListener('mouseleave', function() {
            card.style.setProperty('--mouse-x', '50%');
            card.style.setProperty('--mouse-y', '50%');
        });
    });
}
```

## How It Works

### 1. **CSS Custom Properties**
- Uses CSS custom properties (`--mouse-x`, `--mouse-y`) to track cursor position
- Default position is centered at `50%, 50%`
- Spotlight color uses purple theme: `rgba(138, 99, 210, 0.15)`

### 2. **Pseudo-element (::before)**
- Creates a radial gradient overlay
- Positioned absolutely to cover the entire card
- Initially hidden with `opacity: 0`
- Fades in on hover with smooth transition

### 3. **JavaScript Event Listeners**
- **mousemove**: Updates CSS custom properties with cursor position
- **mouseleave**: Resets position to center when mouse exits

### 4. **Z-index Layering**
```
Card Content (z-index: 1)
    ↑
Spotlight Effect (z-index: 0)
    ↑
Card Background
```

## Features

### ✅ Smooth Animations
- 0.5s fade transition for spotlight appearance
- Smooth gradient following cursor movement
- No performance issues with CSS custom properties

### ✅ Responsive Design
- Works on all screen sizes
- Automatically adjusts to card dimensions
- Disabled on touch devices (no hover state)

### ✅ Customizable
- **Spotlight Size**: Adjust circle radius (400px for programs, 350px for learner cards)
- **Spotlight Color**: Different opacity for different card types
- **Transition Speed**: Modify `transition: opacity 0.5s ease`

## Applied To

1. **Program Detail Cards** (Homepage)
   - Extended Reality (XR): AR & VR
   - Robotics & Intelligent Systems
   - Programming Foundations

2. **Learner Group Cards** (Homepage)
   - School Students
   - College Students
   - Faculty & Educators
   - Professionals & Researchers
   - Career Restart Professionals

## Color Scheme

- **Program Cards**: `rgba(138, 99, 210, 0.15)` - Purple with 15% opacity
- **Learner Cards**: `rgba(138, 99, 210, 0.12)` - Purple with 12% opacity (slightly subtler)
- **Gradient Size**: 400px radius for programs, 350px for learner cards

## Browser Compatibility

✅ Modern browsers supporting:
- CSS Custom Properties
- CSS `::before` pseudo-elements
- JavaScript `addEventListener`
- `getBoundingClientRect()`

## Performance

- **Lightweight**: No external libraries required
- **Efficient**: Uses CSS custom properties (GPU accelerated)
- **Smooth**: No layout recalculation, only property updates
- **Optimized**: Pointer events disabled on overlay

## Customization Guide

### Change Spotlight Color
```css
--spotlight-color: rgba(R, G, B, opacity);
```

### Change Spotlight Size
```css
background: radial-gradient(
  circle [SIZE]px at var(--mouse-x) var(--mouse-y),
  ...
);
```

### Change Fade Speed
```css
transition: opacity [DURATION]s ease;
```

### Add to Other Cards
```javascript
const spotlightCards = document.querySelectorAll('.your-card-class');
```

## Testing

1. Open `http://localhost/Nexalabs/index.php`
2. Scroll to "Programmes Offered" section
3. Hover over any program card
4. Move mouse around to see spotlight follow cursor
5. Move mouse away to see spotlight fade out
6. Repeat for "Learner Groups" section

## Files Modified

1. `assets/css/style.css` - Added spotlight CSS (74 lines)
2. `assets/js/main.js` - Added spotlight JavaScript (21 lines)

## Conversion Notes

### React → Vanilla JS
- `useRef` → `document.querySelectorAll()`
- `onMouseMove` → `addEventListener('mousemove')`
- `ref.current` → `card` (from forEach)
- `style.setProperty()` → Same in vanilla JS
- Component props → CSS custom properties

The implementation maintains all the functionality of the React version while being fully compatible with your PHP/HTML website!
