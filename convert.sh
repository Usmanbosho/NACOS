#!/bin/bash

# Loop through all .html files (except index.html)
for file in *.html; do
  # Skip index.html (homepage)
  if [ "$file" == "index.html" ]; then
    continue
  fi

  # Get filename without extension
  filename="${file%.html}"

  # Make directory with that name
  mkdir -p "$filename"

  # Move the HTML file into the folder as index.html
  mv "$file" "$filename/index.html"

  echo "✅ Converted $file → $filename/index.html"
done

echo "🎉 All .html files converted successfully!"
