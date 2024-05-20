export default function calculatePasswordStrength(pass) {
    let strength = 0;
    if (pass.length >= 8) strength += 1;
    if (pass.match(/\d+/)) strength += 1;
    if (pass.match(/[a-z]/) && pass.match(/[A-Z]/)) strength += 1;
    if (pass.match(/[^a-zA-Z0-9]/)) strength += 1;
    return strength;
}
