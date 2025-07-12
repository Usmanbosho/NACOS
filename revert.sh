#!/bin/bash

for dir in */; do
  folder="${dir%/}"

  if [ -f "$folder/index.html" ]; then
    mv "$folder/index.html" "$folder.html"
    rmdir "$folder"
    echo "🔁 Reverted $folder/index.html → $folder.html"
  fi
done

echo "✅ All files reverted successfully!"
