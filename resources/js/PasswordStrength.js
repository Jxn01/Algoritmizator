/**
 * Calculates the strength of a given password based on various criteria.
 *
 * The function evaluates the strength of a password by checking its length,
 * the presence of digits, the presence of both uppercase and lowercase letters,
 * and the presence of special characters. Each criterion met increases the
 * password strength score by one.
 *
 * @param {string} pass - The password to be evaluated.
 * @returns {number} - The strength of the password, ranging from 0 to 4.
 *                      - 0: Very weak (does not meet any criteria)
 *                      - 1: Weak (meets only one criterion)
 *                      - 2: Moderate (meets two criteria)
 *                      - 3: Strong (meets three criteria)
 *                      - 4: Very strong (meets all four criteria)
 */
function calculatePasswordStrength(pass) {
    // Initialize the strength score to 0.
    let strength = 0;

    // Check if the password length is at least 8 characters.
    if (pass.length >= 8) strength += 1;

    // Check if the password contains at least one digit.
    if (pass.match(/\d+/)) strength += 1;

    // Check if the password contains both lowercase and uppercase letters.
    if (pass.match(/[a-z]/) && pass.match(/[A-Z]/)) strength += 1;

    // Check if the password contains any special characters.
    if (pass.match(/[^a-zA-Z0-9]/)) strength += 1;

    // Return the calculated strength score.
    return strength;
}

// Export the calculatePasswordStrength function as the default export.
export default calculatePasswordStrength;
