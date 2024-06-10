import React, { useEffect } from "react";
import Navbar from "@/components/ui/navbar";
import { useDispatch, useSelector } from "react-redux";
import { fetchPosts } from "@/features/posts/postSlice";

const HomePage = () => {
  const dispatch = useDispatch();
  const { posts, status, error } = useSelector((state) => state.posts);

  useEffect(() => {
    dispatch(fetchPosts());
  }, [dispatch]);

  return (
    <div className="w-full min-h-screen flex flex-col bg-gray-100">
      <Navbar />
      <div className="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <h1 className="text-2xl sm:text-3xl font-semibold text-gray-800 mb-4">
          Forum Feed
        </h1>
        {status === "loading" && <p>Loading posts...</p>}
        {status === "failed" && <p>Error: {error}</p>}
        {status === "succeeded" && (
          <ul className="space-y-4">
            {posts.data.map((post) => (
              <li
                key={post.id}
                className="bg-white shadow-sm rounded-md p-4 sm:p-6"
              >
                <h2 className="text-lg font-semibold text-gray-900 mb-2">
                  {post.title}
                </h2>
                <p className="text-gray-700 mb-4">{post.content}</p>
                <div className="mt-2 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                  <span className="text-sm text-gray-600">
                    Posted by {post.user ? post.user.name : "Unknown"} •{" "}
                    {new Date(post.created_at).toLocaleDateString()}
                  </span>
                  <div className="flex space-x-4 mt-2 sm:mt-0">
                    <span className="text-sm text-gray-600">
                      {post.likes_count} Likes
                    </span>
                    <span className="text-sm text-gray-600">
                      {post.comments_count} Comments
                    </span>
                  </div>
                </div>
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  );
};

export default HomePage;
