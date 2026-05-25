#!/bin/bash

# Script to share the local afbarbershop project with a client using authenticated Expose.

echo "🚀 Launching public URL for afbarbershop..."

# Ensure we use the correct PHP and Expose binary paths since CLI might be temperamental
PHP_BIN="/Users/pondokit/Library/Application Support/Herd/bin/php84"
EXPOSE_BIN="/Users/pondokit/Library/Application Support/Herd/bin/expose"

if [ -f "$PHP_BIN" ] && [ -f "$EXPOSE_BIN" ]; then
    "$PHP_BIN" "$EXPOSE_BIN" share afbarbershop.test
else
    echo "⚠️ Falling back to standard commands..."
    herd share
fi
